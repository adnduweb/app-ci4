<?php

namespace Adnduweb\Ci4Core\Core;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\Services;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use CodeIgniter\Files\File;
//use Adnduweb\Ci4Core\Core\ImageManger;
use Tatter\Handlers\Handlers;
use Adnduweb\Ci4Core\Config\ImageManger as ImageMangerConfig;
use Adnduweb\Ci4Core\Exceptions\ThumbnailsException;
use Adnduweb\Ci4Core\Interfaces\ImageManagerInterface;

class BaseImageManger
{
		/**
	 * The configuration instance.
	 *
	 * @var ImageMangerConfig
	 */
	protected $config;

	/**
	 * Output width.
	 *
	 * @var integer
	 */
	protected $width;

	/**
	 * Output height.
	 *
	 * @var integer
	 */
	protected $height;

	/**
	 * The image type constant.
	 *
	 * @var integer
	 *
	 * @see https://www.php.net/manual/en/function.image-type-to-mime-type.php
	 */
	protected $imageType;

	// /**
	//  * Overriding name of a handler to use.
	//  *
	//  * @var string|null
	//  */
	// protected $handler;

	// /**
	//  * The library for handler discovery.
	//  *
	//  * @var Handlers
	//  */
	// protected $handlers;

	/**
	 * Attributes for Tatter\Handlers
	 *
	 * @var array<string, string>  Must include keys: name, extensions
	 */
	public $attributes = [
		'name'       => 'Image',
		'extensions' => 'jpg,jpeg,png,gif,xbm,xpm,wbmp,webp,bmp',
	];



	/**
	 * Initializes the library with its configuration.
	 *
	 * @param ImageMangerConfig|null $config
	 */
	public function __construct(ImageMangerConfig $config = null)
	{
		$this->setConfig($config);
		//$this->ImageManger = new ImageManger();

	}

	/**
	 * Sets the configuration to use.
	 *
	 * @param ImageMangerConfig|null $config
	 *
	 * @return $this
	 */
	public function setConfig(ImageMangerConfig $config = null): self
	{
		$this->config = $config ?? config('ImageManger');

		return $this;
	}

	/**
	 * Sets the output image type.
	 *
	 * @param integer $imageType
	 *
	 * @return $this
	 */
	public function setImageType(int $imageType): self
	{
		$this->imageType = $imageType;
		return $this;
	}

	/**
	 * Sets the output image width.
	 *
	 * @param integer $width
	 *
	 * @return $this
	 */
	public function setWidth(int $width): self
	{
		$this->width = $width;
		return $this;
	}

	/**
	 * Sets the output image height.
	 *
	 * @param integer $height
	 *
	 * @return $this
	 */
	public function setHeight(int $height): self
	{
		$this->height = $height;
		return $this;
	}



	/**
	 * Gets all handlers that support a certain file extension.
	 *
	 * @param string $extension The file extension to match
	 *
	 * @return ImageManagerInterface[]
	 */
	public function matchHandlers(string $extension): array
	{
		$handlers = [];

		if (stripos($this->attributes['extensions'], $extension) !== false) {
			// Make sure actual matches get preference over generic ones
			array_unshift($handlers, $extension);
		}

		return $handlers;
	}

	//--------------------------------------------------------------------

	/**
	 * Reads and verifies the file then passes to a supported handler to
	 * create the thumbnail.
	 *
	 * @param string $input  Path to the input file
	 * @param string $output Path to the input file
	 *
	 * @return $this
	 * @throws FileNotFoundException
	 * @throws ThumbnailsException
	 */
	public function create(string $input, string $output): self
	{

		// Validate the file
		$file = new File($input);
		if (! $file->isFile())
		{
			throw FileNotFoundException::forFileNotFound($input);
		}
	
		// Get the file extension
		if (! $extension = $file->guessExtension() ?? pathinfo($input, PATHINFO_EXTENSION))
		{
			throw new ThumbnailsException(lang('Thumbnails.noExtension'));
		}

		// // Determine which handlers to use
		$extensionExist = $this->matchHandlers($extension);

		// // No handlers matched?
		if (empty($extensionExist)) {
			throw new ThumbnailsException(lang('Thumbnails.noImageExtensionDispo', [$extension]));
		}

		// Try each handler until one succeeds
		$result = false;

		if(service('settings')->get('Medias.format', 'watermark') == 1 && !empty(service('settings')->get('Medias.format', 'text_watermark'))){

			if ( \Config\Services::image()
				
				->withFile($file->getRealPath() ?: $file->__toString())
				->fit($this->width, $this->height, 'center')
				->text(service('settings')->get('Medias.format', 'text_watermark'), [            
					'color'      => '#fff',             
					'opacity'    => 0.5,            
					'withShadow' => true,            
					'hAlign'     => 'center',             
					'vAlign'     => 'center',             
					'fontSize'   => 20         
				]) 
				->convert($this->getImageType($file->getMimeType()))
				
				->save($output)){
				if (exif_imagetype($output) === $this->getImageType($file->getMimeType())){
					$result = true;
				}
			}

		}else{
			if ( \Config\Services::image()
				
				->withFile($file->getRealPath() ?: $file->__toString())
				->fit($this->width, $this->height, 'center')
				->convert($this->getImageType($file->getMimeType()))
				
				->save($output)){
				if (exif_imagetype($output) === $this->getImageType($file->getMimeType())){
					$result = true;
				}
			}
		}

		if (! $result)
		{
			throw new ThumbnailsException(lang('Thumbnails.createFailed', [$input]));
		}

		return $this;
	}


		/**
	 * Uses a framework image handler to fit the image to its new size.
	 *
	 * @param File    $file      The file that needs a thumbnail
	 * @param string  $output    Path to the output file
	 * @param integer $imageType A PHP imagetype constant, https://www.php.net/manual/en/function.image-type-to-mime-type.php
	 * @param integer $width     Width of the created thumbnail
	 * @param integer $height    Height of the created thumbnail
	 *
	 * @return boolean  Success or failure
	 */
	public function createWebp($media, string $path): self
	{

		list($width, $height, $type, $attr) = getimagesize($path . DIRECTORY_SEPARATOR .$media->localname.'.webp');

		try
		{
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 180) ? 180 : $width, ($width > 180) ? 180 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_180w.webp');
			// echo 'exit'; exit;
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 360) ? 360 : $width, ($width > 360) ? 360 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_360w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 540) ? 540 : $width, ($width > 360) ? 360 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_540w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 720) ? 720 : $width, ($width > 720) ? 720 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_720w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 900) ? 900 : $width, ($width > 900) ? 900 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_900w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 1080) ? 1080 : $width, ($width > 1080) ? 1080 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1080w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 1260) ? 1260 : $width, ($width > 1260) ? 1260 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1260w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 1440) ? 1440 : $width, ($width > 1440) ? 1440 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1440w.webp');
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.webp')
				->resize(($width > 1620) ? 1620 : $width, ($width > 1620) ? 1620 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1620w.webp');

			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 180) ? 180 : $width, ($width > 180) ? 180 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_180w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 360) ? 360 : $width, ($width > 360) ? 360 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_360w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 540) ? 540 : $width, ($width > 360) ? 360 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_540w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 720) ? 720 : $width, ($width > 720) ? 720 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_720w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 900) ? 900 : $width, ($width > 900) ? 900 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_900w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 1080) ? 1080 : $width, ($width > 1080) ? 1080 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1080w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 1260) ? 1260 : $width, ($width > 1260) ? 1260 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1260w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 1440) ? 1440 : $width, ($width > 1440) ? 1440 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1440w.' . $media->ext);
			\Config\Services::image()
				->withFile($path . DIRECTORY_SEPARATOR .$media->localname.'.' . $media->ext)
				->resize(($width > 1620) ? 1620 : $width, ($width > 1620) ? 1620 : $width, true, 'wight')
				->save($path .DIRECTORY_SEPARATOR . 'responsive-images' . DIRECTORY_SEPARATOR .$media->localname.'_1620w.' . $media->ext);
		}
		catch (ImageException $e)
		{
			throw new ThumbnailsException(lang('Thumbnails.createFailed', [$input]));
		}
		return $this;
	}

	public function getImageType(string $mine){
		$types = [
            'image/gif' => IMAGETYPE_GIF,
			'image/jpeg' => IMAGETYPE_JPEG,
			'image/jpg' => IMAGETYPE_JPEG,
			'image/png' => IMAGETYPE_PNG,
            'image/webp' => IMAGETYPE_WEBP,
		];
		
		return $types[$mine];
	}
}
