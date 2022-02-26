<?php

namespace Adnduweb\Ci4Medias\Entities;

use Michalsn\Uuid\UuidEntity;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use Config\Mimes;
use Adnduweb\Ci4Medias\Structures\MediaObject;
use CodeIgniter\I18n\Time;

class Media extends UuidEntity
{
	use \Tatter\Relations\Traits\EntityTrait;
	use \Adnduweb\Ci4Core\Traits\BuilderEntityTrait;

	protected $table          = 'medias';
	protected $tableLang      = 'medias_langs';
	protected $primaryKey     = 'id';
	protected $primaryKeyLang = 'media_id';
	protected $uuids          = ['uuid'];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];

    /**
     * Resolved path to the default thumbnail
     */
    protected static ?string $defaultThumbnail = null;


	public function getID(){
        return isset($this->attributes['id']) ? ucfirst($this->attributes['id']) : '';
    }

	public function getUuid()
	{
		return $this->attributes['uuid'] ?? null;
	}

	public function getType()
	{
		return $this->attributes['type'] ?? null;
	}

	public function getSize()
	{
		return $this->attributes['size'] ?? null;
	}

	public function getFilename()
	{
		return $this->attributes['filename'] ?? null;
	}

	public function getName(){
        return isset($this->attributes['titre']) ? ucfirst($this->attributes['titre']) : lang('Core.Pas de titre');
	}
	
	public function getFullName(){
        return isset($this->attributes['titre']) ? ucfirst($this->attributes['titre']) : lang('Core.Pas de titre');
    }

	public function setCreatedAt(string $dateString)
	{
		return $this->attributes['created_at'] = new Time($dateString, 'UTC');
	}

	public function getOrientation()
	{
		$pathOriginal = config('Medias')->getPath() . 'original' . DIRECTORY_SEPARATOR . ($this->attributes['localname'] ?? '');
		list($width, $height) = getimagesize($pathOriginal);
		$orientation = ( $width != $height ? ( $width > $height ? 'landscape' : 'portrait' ) : 'square' );

		return $orientation;
	}

	public function getUrlMedia(string $dir, $width = false, $height = false)
	{
		// echo $this->attributes['id']; exit;
		$pathOriginal = config('Medias')->getPath() . $dir . DIRECTORY_SEPARATOR . ($this->attributes['localname'] ?? '');
		if (!is_file($pathOriginal)) {
			$pathOriginal = self::locateDefaultThumbnail();
		}else{
			$pathOriginal = config('Medias')->segementUrl . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $this->attributes['filename'];
		}

		
		if($dir == 'custom'){
			list($filename, $extension) = explode('.', $this->attributes['filename']);
			$pathOriginal =  config('Medias')->segementUrl . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $filename . '-' . $width . 'x' . $height . '.'. $extension;
		}

		return site_url($pathOriginal);
	}


	public function nameFile(){

		return $this->attributes['localname'] ?? null;
	}


	public function getPath( string $directory){

		$path = config('Medias')->getPath()  . DIRECTORY_SEPARATOR  .  $directory . DIRECTORY_SEPARATOR  .  $this->attributes['localname'];
        return realpath($path) ?: $path;
	}


	/**
	 * Returns the absolute path to the configured default thumbnail
	 *
	 * @return string
	 *
	 * @throws FileNotFoundException
	 */
	public static function locateDefaultThumbnail(): string
	{

    	 // If the path has not been resolved yet then try to now
		 if (null === self::$defaultThumbnail) {
            $path = WRITEPATH . config('Medias')->defaultThumbnail;
            $ext  = pathinfo($path, PATHINFO_EXTENSION);

            if (! self::$defaultThumbnail = file_exists($path)) {
                throw new FileNotFoundException('Could not locate default thumbnail: ' . $path);
            }
        }

		return (string)  site_url(config('Medias')->defaultThumbnail);
		
	}

	//--------------------------------------------------------------------

    /**
     * Returns the most likely actual file extension
     *
     * @param string $method Explicit method to use for determining the extension
     */
    public function getExtension($method = ''): string
    {
		if ($this->attributes['type'] !== 'application/octet-stream') {
            if ((! $method || $method === 'type') && ($extension = Mimes::guessExtensionFromType($this->attributes['type']))) {
                return $extension;
            }

            if ((! $method || $method === 'mime') && ($file = $this->getObject()) && ($extension = $file->guessExtension())) {
                return $extension;
            }
        }

        foreach (['clientname', 'localname', 'filename'] as $attribute) {
            if (! $method || $method === $attribute) {
                if ($extension = pathinfo($this->attributes[$attribute], PATHINFO_EXTENSION)) {
                    return $extension;
                }
            }
        }

        return '';
    }
	/**
	 * Returns a MediaObject (CIFile/SplFileInfo) for the local file
	 *
	 * @return MediaObject|null  `null` for missing file
	 */
	public function getObject(): ?MediaObject
	{
		try {
			return new MediaObject($this->getPath('thumbnails'), true);
		} catch (FileNotFoundException $e) {
			return null;
		}
	}


	/**
	 * Returns the path to this file's thumbnail, or the default from config.
	 * Should always return a path to a valid file to be safe for img_data()
	 *
	 * @return string
	 */
	public function getThumbnail(): string
	{
		$path = config('Medias')->getPath() . 'thumbnails' . DIRECTORY_SEPARATOR . ($this->attributes['thumbnail'] ?? '');
			
		if (!is_file($path)) {
            $setThumbnail = self::locateDefaultThumbnail();
        }else{
			$setThumbnail = site_url(config('Medias')->segementUrl . DIRECTORY_SEPARATOR . 'thumbnails' . DIRECTORY_SEPARATOR . $this->attributes['filename']);
		}

		return $setThumbnail;
	}

	/**
	 * Returns the path to this file's original, or the default from config.
	 * Should always return a path to a valid file to be safe for img_data()
	 *
	 * @return string
	 */
	public function getOriginal(): string
	{
		$path = config('Medias')->getPath() . 'original' . DIRECTORY_SEPARATOR . ($this->attributes['thumbnail'] ?? '');
			
		if (!is_file($path)) {
            $setThumbnail = self::locateDefaultThumbnail();
        }else{
			$setThumbnail = site_url(config('Medias')->segementUrl . DIRECTORY_SEPARATOR . 'original' . DIRECTORY_SEPARATOR . $this->attributes['filename']);
		}

		return $setThumbnail;
	}

	/**
	 * Returns the path to this file's medium, or the default from config.
	 * Should always return a path to a valid file to be safe for img_data()
	 *
	 * @return string
	 */
	public function getMedium(): string
	{
		$path = config('Medias')->getPath() . 'medium' . DIRECTORY_SEPARATOR . ($this->attributes['thumbnail'] ?? '');
			
		if (!is_file($path)) {
            $setThumbnail = self::locateDefaultThumbnail();
        }else{
			$setThumbnail = site_url(config('Medias')->segementUrl . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR . $this->attributes['filename']);
		}

		return $setThumbnail;
	}

	

	public function getAllDimensions($all = true){

		helper('medias');
		$dimensions = [];
		$dimensionsCustom = [];
		foreach(config('Medias')->sizeDefault as $sizeDefault){

			$file = new \CodeIgniter\Files\File($this->getPath($sizeDefault));
			list($width, $height, $type, $attr) =  getimagesize($this->getPath($sizeDefault));
			
			$dimensions[] = [
				'dimension' => $sizeDefault,
				'uuid' => $this->getUUID(),
				'width' => $width,
				'height' => $height,
				'type' => $type,
				'attr' => $attr,
				'size' => bytes2human($file->getSize()),
				'localname' => $this->localname,
				'urlThumbnail' => $this->getUrlMedia('thumbnails'),
				'url' => $this->getUrlMedia($sizeDefault),
				'date' => \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime($this->getPath('thumbnails'))))->humanize(),
				'natif' => true
		   ];

		}


		$customFiles = glob(config('Medias')->getPath() . 'custom/' . $this->localname . '*');

		if (!empty($customFiles)) {
			$i = 0;
			foreach ($customFiles as $custom) {
				 $file = new \CodeIgniter\Files\File($custom);
				 list($width, $height, $type, $attr) =  getimagesize($custom);

				$dimensionsCustom[$i] = [
					'dimension' => 'custom',
					'uuid' => $this->getUUID(),
					'width' => $width,
					'height' => $height,
					'type' => $type,
					'attr' => $attr,
					'size' => bytes2human($file->getSize()),
					'localname' => $this->localname,
					'urlThumbnail' => $this->getUrlMedia('thumbnails'),
					'url' => $this->getUrlMedia('custom', $width, $height),
					'date' => \CodeIgniter\I18n\Time::parse(date("F d, Y H:i:s", filemtime($custom)))->humanize(),
					'natif' => false
			   ];
			   $i++;
			}
			$dimensions = array_merge($dimensions, $dimensionsCustom);
		}
			
		$this->attributes['dimensions'] = $dimensions;		
		//print_r($this->attributes['dimensions']);exit;

		if($all == true){
			return $this;
		}else{
			return $this->attributes['dimensions'];
		}
			
	}

}
