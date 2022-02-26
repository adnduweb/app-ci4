<?php 

namespace Adnduweb\Ci4Medias\Config;

use CodeIgniter\Config\BaseConfig;

class Medias extends BaseConfig
{


	/**
     * Whether to include routes to the Files Controller.
     *
     * @var bool
     */
    public $routeFiles = true;

    /**
     * View file aliases
     *
     * @var string[]
     */
    public $views = [
        'dropzone' => 'Adnduweb\Ci4Medias\Views\themes\metronic\Dropzone\config',
    ];

	//--------------------------------------------------------------------
    // Display Preferences
    //--------------------------------------------------------------------

    /**
     * Display format for listing files.
     * Included options are 'cards', 'list', 'select'
     *
     * @var string
     */
    public $format = 'list';

    /**
     * Default sort column.
     * See FileModel::$allowedFields for options.
     *
     * @var string
     */
    public $sort = 'filename';

    /**
     * Default sort ordering. "asc" or "desc"
     *
     * @var string
     */
	public $order = 'asc';
	
 	/**
     * Default size 
     *
     * @var array
     */
	public $sizeDefault = ['thumbnails', 'small', 'medium', 'large'];


	//--------------------------------------------------------------------
    // Storage Options
    //--------------------------------------------------------------------

    /**
     * Directory to store files (with trailing slash).
     * Usually best to use getPath()
     *
     * @var string
     */
	protected $path = WRITEPATH . 'medias' . DIRECTORY_SEPARATOR;

	    /**
     * Directory to store files (with trailing slash).
     * Usually best to use getPath()
     *
     * @var string
     */
    public $segementUrl = 'medias';
    

    /**
     * Path to the default thumbnail file
     */
    public string $defaultThumbnail = 'medias' . DIRECTORY_SEPARATOR . 'thumbnails/default.jpg';


	/**
     * Normalizes and creates (if necessary) the storage and thumbnail paths,
     * returning the normalized storage path.
     *
     * @throws FilesException
     */
    public function getPath(): string
    {
        $storage = $this->path;

        // Verify the storage directory
        if (! is_dir($storage) && ! @mkdir($storage, 0775, true)) {
            throw FilesException::forDirFail($storage);
        }

        // Normalize the storage path
        $this->path = realpath($storage) ?: $storage;
        $this->path = rtrim($storage, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        // Check or create the thumbnails subdirectory
        $thumbnails = $storage . 'thumbnails';
        if (! is_dir($thumbnails) && ! @mkdir($thumbnails, 0775, true)) {
            throw FilesException::forDirFail($thumbnails); // @codeCoverageIgnore
		}
		
		// Normalize the path
		$small = $storage . 'small';
		if (! is_dir($small) && ! @mkdir($small, 0775, true)){
			throw MediasException::forDirFail($small);
		}

		// Normalize the path
		$original = $storage . 'original';
		if (! is_dir($original) && ! @mkdir($original, 0775, true)){
			throw MediasException::forDirFail($original);
		}

		// Normalize the path
		$medium = $storage . 'medium';
		if (! is_dir($medium) && ! @mkdir($medium, 0775, true)){
			throw MediasException::forDirFail($medium);
		}

		// Normalize the path
		$large = $storage . 'large';
		if (! is_dir($large) && ! @mkdir($large, 0775, true)){
			throw MediasException::forDirFail($large);
		}

		// Normalize the path
		$custom = $storage . 'custom';
		if (! is_dir($custom) && ! @mkdir($custom, 0775, true)){
			throw MediasException::forDirFail($custom);
		}

        return $storage;
	}
	


	/**
     * Changes the storage path value. Mostly just for testing.
     */
    public function setPath(string $path)
    {
        $this->path = $path;
	}


	public $extensionImage =  'jpg,jpeg,png,gif,xbm,xpm,wbmp,webp,bmp';

	public $extensionDoc =  ['doc','docx','xls','csv','pdf'];

	public $extensionAllowed =  'jpg,jpeg,png,gif,xbm,xpm,wbmp,webp,bmp,doc,docs,xls,csv,pdf';

	public function createPermissions(): array
    {

        $permissions = [
			[
                'name'              => 'medias.index',
                'description'       => "Voir les médias",
                'is_natif'          => false,
			],
            [
                'name'              => 'medias.list',
                'description'       => "Voir les médias",
                'is_natif'          => false,
			],
			[
                'name'              => 'medias.grid',
                'description'       => "Voir les médias",
                'is_natif'          => false,
            ],
           
            [
                'name'              => 'medias.edit',
                'description'       => "Modifier les médias",
                'is_natif'          => false,
            ],
            [
                'name'              => 'medias.delete',
                'description'       => "Supprimer les médias",
                'is_natif'          => false,
            ],
            [
                'name'              => 'medias.settings',
                'description'       => "Voir les médias",
                'is_natif'          => false,
            ],
        ];

        return $permissions;

	}
}
