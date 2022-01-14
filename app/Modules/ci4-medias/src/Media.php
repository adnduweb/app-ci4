<?php

namespace Adnduweb\Ci4Medias;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Config\Services;
use Adnduweb\Ci4Medias\Config\Media as MediaConfig;

class Media
{
		/**
	 * The configuration instance.
	 *
	 * @var MediaConfig
	 */
	protected $config;

	/**
	 * Initializes the library with its configuration.
	 *
	 * @param MediaConfig|null $config
	 */
	public function __construct(MediaConfig $config = null)
	{
		$this->setConfig($config);
		//$this->ImageManger = new ImageManger();

	}

	/**
	 * Sets the configuration to use.
	 *
	 * @param MediaConfig|null $config
	 *
	 * @return $this
	 */
	public function setConfig(MediaConfig $config = null): self
	{
		$this->config = $config ?? config('media');

		return $this;
    }
    
    public function addParamsJs(){

        helper('medias');
        $uploadLimitBytes = max_file_upload_in_bytes();

		// Buffer chunks to be just under the limit (maintain bytes)
		$chunkSize = $uploadLimitBytes - 1000;

		// Limit files to the MB equivalent of 500 chunks
		$maxFileSize = round($chunkSize * 500 / 1024 / 1024, 1);

		$paramJs =
			json_encode([
				'storage'          => Config('Medias')->getPath(),
				'segementUrl'      => Config('Medias')->segementUrl,
				'uploadLimitBytes' => max_file_upload_in_bytes(),
                'urlUpload'        => site_url(route_to('media-upload')),
                'urlUploadFinal'        => site_url(route_to('media-upload-final')),
				'chunkSize'        => $chunkSize,
				'maxFileSize'      => $maxFileSize,
				'acceptedFiles'    => 'image/*,application/pdf',
				'maxFiles'         => 20,
				'id_media_default' => 1,
				'url_media_default' => site_url(Config('Medias')->segementUrl) . '/medium/default.jpg',
            ]);

            return $paramJs;
    }

	
}
