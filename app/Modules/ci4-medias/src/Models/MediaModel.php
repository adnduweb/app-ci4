<?php namespace Adnduweb\Ci4Medias\Models;

use CodeIgniter\Files\File as CIFile;
use Michalsn\Uuid\UuidModel;
use Config\Mimes;
use Faker\Generator;
use Adnduweb\Ci4Medias\Entities\Media;
use Adnduweb\Ci4Medias\Exceptions\MediasException;
use Adnduweb\Ci4Core\Exceptions\ThumbnailsException;


class MediaModel extends UuidModel
{
	//use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Core\Traits\AuditsTrait, \Adnduweb\Ci4Core\Models\BaseModel;
	//use \Tatter\Permits\Traits\PermitsTrait;
	use \Tatter\Relations\Traits\ModelTrait, \Adnduweb\Ci4Core\Traits\AuditsTrait;

	protected $table          = 'medias';
	protected $primaryKey     = 'id';
	protected $returnType     = Media::class;
	protected $lang           = true;
	protected $tableLang      = 'medias_langs';
	protected $uuidFields     = ['uuid'];
	protected $useSoftDeletes = false;
	protected $searchTable    = ['medias', 'medias_langs'];

	protected $allowedFields = [
		'uuid',
		'filename',
		'localname',
		'clientname',
		'type',
		'size',
		'ext',
		'thumbnail',
		'updated_at'
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules = [
		'filename' => 'required|max_length[255]',
		// file size in bytes
		'size'     => 'permit_empty|is_natural',
	];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;


	// Permits
	protected $mode       = 04660;
	protected $userKey    = 'user_id';
	protected $pivotKey   = 'media_id';
	protected $usersPivot = 'medias_users';


	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = ['auditInsert'];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = ['auditUpdate', 'updatelang'];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = ['auditDelete'];


	const ORDERABLE = [
        1 => 'titre',
        6 => 'created_at',
    ];

    public static $orderable = ['titre', 'created_at'];

	//--------------------------------------------------------------------

	public function __construct()
    {
        parent::__construct();
		$this->builder           = $this->db->table('medias');
		$this->builder_langs     = $this->db->table('medias_langs');
		$this->builder_downloads = $this->db->table('medias_downloads');
		$this->builder_users     = $this->db->table('medias_users');

    }


	/**
	 * Associates a file with a user
	 *
	 * @param integer $mediaId
	 * @param integer $userId
	 *
	 * @return boolean
	 */
	public function addToUser(int $mediaId, int $userId): bool
	{
		return (bool) $this->db->table('medias_users')->insert([
			'media_id' => $mediaId,
			'user_id' => $userId,
		]);
	}

	/**
	 * Associates a file with an lang
	 *
	 * @param integer $mediaId
	 * @param integer $userId
	 *
	 * @return boolean
	 */
	public function addToLang(int $mediaId, string $titre): bool
	{
		return (bool) $this->db->table('medias_langs')->insert([
			'media_id' => $mediaId,
			'titre' => $titre,
			'lang' => service('request')->getLocale(),
		]);
	}


	/**
	 * Returns an array of all a user's Files
	 *
	 * @param integer $userId
	 *
	 * @return array
	 */
	public function getForUser(int $userId): array
	{
		return $this->whereUser($userId)->findAll();
	}

	/**
	 * Adds a where filter for a specific user.
	 *
	 * @param integer $userId
	 *
	 * @return $this
	 */
	public function whereUser(int $userId): self
	{
		$this->select('files.*')
			->join('medias_users', 'medias_users.media_id = files.id', 'left')
			->where('user_id', $userId);

		return $this;
	}

	/**
	 * 
	 */
	public function deleteAll(){
		$this->db->table('medias')->emptyTable('medias');
		$this->db->table('medias')->emptyTable('medias_users');
		$this->db->table('medias')->emptyTable('medias_downloads');

		return $this;
	}

	//--------------------------------------------------------------------

	/**
	 * Creates a new File from a path File. See createFromFile().
	 *
	 * @param string $path
	 * @param array  $data Additional data to pass to insert()
	 *
	 * @return File
	 */
	public function createFromPath(string $path, array $data = []): Media
	{
		return $this->createFromFile(new CIFile($path, true), $data);
	}

	/**
	 * Creates a new File from a framework File. Adds it to the
	 * database and moves it into storage (if it is not already).
	 *
	 * @param CIFile $file
	 * @param array  $data Additional data to pass to insert()
	 *
	 * @return File
	 */
	public function createFromFile(CIFile $file, array $data = []): Media
	{
		helper('string');
		// Gather file info
		$row = [
			'filename'   => $file->getFilename(),
			'localname'  => $file->getRandomName(),
			'clientname' => $file->getFilename(),
			'type'       => Mimes::guessTypeFromExtension($file->getExtension()) ?? $file->getMimeType(),
			'size'       => $file->getSize(),
			'ext' 		 => $file->guessExtension()
		];

		// Merge additional data
		$row = array_merge($row, $data);

        // Normalize paths
        $storage  = config('Medias')->getPath();
        $filePath = $file->getRealPath() ?: (string) $file;


		// Determine if we need to move the file
		if (strpos($filePath, $storage . 'original/') === false)
		{
			// Move the file
			$file = $file->move($storage . 'original/', $row['localname'] );
			chmod($storage . 'original/' . $row['localname'], 0664);
		}

		//Verify
		$row['clientname'] = uniforme(pathinfo($row['clientname'], PATHINFO_FILENAME))  . '.'. $row['ext' ];
		$row['filename'] = $this->verififyExistFile($row);
		
		
		// Record it in the database
		$mediaId = $this->insert($row);

		$titre = str_replace('.' . $row['ext'], '', $row['filename']);
		$titre = str_replace('-', ' ', $titre);
		$this->addToLang($mediaId, $titre);

		// If a user is logged in then associate the File
		if ($userId = user()->id)
		{
			$this->addToUser($mediaId, $userId);
		}

		// Is it an image?
		if (strpos(config('Medias')->extensionImage, $row['ext' ]) === false){

			return $this->find($mediaId);
		}
		
		$outputThumbnail    = $storage . 'thumbnails' . DIRECTORY_SEPARATOR . pathinfo($row['localname'], PATHINFO_FILENAME);
		$outputSmall    = $storage . 'small' . DIRECTORY_SEPARATOR . pathinfo($row['localname'], PATHINFO_FILENAME);
		$outputMedium    = $storage . 'medium' . DIRECTORY_SEPARATOR . pathinfo($row['localname'], PATHINFO_FILENAME);
		$outputlarge    = $storage . 'large' . DIRECTORY_SEPARATOR . pathinfo($row['localname'], PATHINFO_FILENAME);

		list($thumbnailWidth, $thumbnailHeight) = explode('|', service('settings')->get('Medias.format', 'thumbnail'));
		list($smallWidth, $smallHeight) = explode('|', service('settings')->get('Medias.format', 'small'));
		list($mediumWidth, $mediumHeight) = explode('|', service('settings')->get('Medias.format', 'medium'));
		list($largeWidth, $largeHeight) = explode('|', service('settings')->get('Medias.format', 'large'));

		try
		 {

			service('imageManger')->setWidth($thumbnailWidth)->setHeight($thumbnailHeight)->create((string) $file, $outputThumbnail);

			service('imageManger')->setWidth($smallWidth)->setHeight($smallHeight)->create((string) $file, $outputSmall);
			service('imageManger')->setWidth($mediumWidth)->setHeight($mediumHeight)->create((string) $file, $outputMedium);
			service('imageManger')->setWidth($largeWidth)->setHeight($largeHeight)->create((string) $file, $outputlarge);

			// If it succeeds then update the database
			$this->update($mediaId, [
				'thumbnail' => $file->getFilename(),
			]);

			// delete Dir 

			echo WRITEPATH . 'uploads/' . $row['uuid'];exit;
			rmdir(WRITEPATH . 'uploads/' . $row['uuid']);
		}
		catch (\Throwable $e)
		{
			log_message('error', $e->getMessage());
			log_message('error', 'Unable to create thumbnail for ' . $row['filename']);
		}

		// Return the File entity
		return $this->find($mediaId);
	}

	public function search(string $search){

		$result = [];

		//MEDIAS
		$fieldsMedias = $this->db->getFieldNames('medias');

		$i = 0;
		$tempArray = [];
		foreach ($fieldsMedias as $field)
		{
			$tempArray[$field] = $search;
			$i++;
		}
		
		$this->builder->orLike($tempArray);  
		$res = $this->builder->get()->getResultArray();

		$item = [];
		if(!empty($res)){
			foreach ($res as $s){
				$item[] = new $this->returnType($s);
			}
		}

		//MEDIAS LANGS
		$fieldsMediaslangs = $this->db->getFieldNames('medias_langs');

		$i = 0;
		$tempArray = [];
		foreach ($fieldsMediaslangs as $field)
		{
			$tempArray[$field] = $search;
			$i++;
		}
		
		$this->builder_langs->orLike($tempArray);  
		$res = $this->builder_langs->get()->getResult();

		$item1 = [];
		if(!empty($res)){
			foreach ($res as $s){
				$item1[] = new $this->returnType($this->builder->where('id', $s->media_id)->get()->getRowArray());
			}
		}

		$result = array_merge($item, $item1);

		return $result;

	}

	/**
	 * 
	 * NEW
	 */


  /**
     * Get resource data.
     *
     * @param string $search
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function getResource(string $search = '')
    {
        $builder =  $this->db->table('medias')
            ->select('*')->join('medias_langs', 'medias.id = medias_langs.media_id')->where('lang', service('request')->getLocale());

        $condition = empty($search)
            ? $builder
            : $builder->groupStart()
                ->like('titre', $search)
                ->orLike('medias.created_at', $search)
			->groupEnd();
			

        return $condition->where([
            'medias.deleted_at'  => null,
            'medias.deleted_at' => null,
        ]);
    }

    public function updatelang($params){

        if($this->lang == true){

			$post = (!empty(service('request')->getPost())) ? service('request')->getPost() : (array)json_decode(service('request')->getBody());
			//print_r($params); exit;

			// Je viens des formaulaire 
            if(isset($post['lang'])){                
                
                $data = $post['lang'][service('request')->getLocale()];
                $data['lang'] = service('request')->getLocale();

               if(!$this->db->table('medias_langs')->update($data, ['id_media_lang' => $post['id_media_lang']])){
                    return $this->errors();
               }
            }else{
				if($params['result'] = true){
					$data = $post;
					unset($data['uuid']);

					if(!$this->db->table('medias_langs')->update($data, ['media_id' => $params['id'][0], 'lang' => service('request')->getLocale()])){
							return $this->errors();
					}
				}
			}

        }
	}
	
	public function getMediaByUUID(string $UUID){

		$media = $this->select()
		->join('medias_langs', 'medias.id = medias_langs.media_id')
		->where('uuid', $this->uuid->fromString($UUID)->getBytes())
		->where('lang', service('request')->getLocale())
		->first();
	
		return $media;

	}

	public function getMedias($paginate = false, $perPage = false, $theme = false, $page = false, $type= false){

		if($paginate == true){
			$media = $this->select()
			->join('medias_langs', 'medias.id = medias_langs.media_id')
			->like("type", $type)
			->where('lang', service('request')->getLocale())
			->where('medias.id != 1') // Image par default
			->orderBy('medias.id ASC')
			->paginate($perPage, $theme, $page);
		}
		else{
			$media = $this->select()
			->join('medias_langs', 'medias.id = medias_langs.media_id')
			->like("type", $type)
			->where('lang', service('request')->getLocale())
			->where('medias.id != 1') // Image par default
			->orderBy('medias.id ASC')
			->findAll();
		}
	
		return $media;

	}

	/**
	 * Verify file existe
	 */
	public function verififyExistFile( array $file ){

		
		$media = $this->select('clientname')
		->where('clientname', $file['clientname'])
		->findAll();

		if(!empty($media)){
			list($pathinfo, $extension) = explode('.', $media[0]->clientname);
			//echo $pathinfo . '_'.count($media) + 1 .'.' . $extension; exit;
			return $pathinfo . '_'.count($media) + 1 .'.' . $extension;
		}
	
		return $file['clientname'];

	}

	/**
	 * Get Localname
	 */
	public function getMediaByFilename( string $filename ){

		$media = $this->select('localname')
		->where('filename', $filename)
		->first();

		//print_r($media); exit;
		if(!empty($media))
			return $media->localname;

		return false;
	}


	


}
