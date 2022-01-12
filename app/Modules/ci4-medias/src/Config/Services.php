<?php namespace Adnduweb\Ci4Medias\Config;

use CodeIgniter\Model;
use Adnduweb\Ci4Medias\Config\Media as MediaConfig;
use Adnduweb\Ci4Medias\Media;
use Config\Services as BaseService;

class Services extends BaseService
{
  
	/**
	 * Return List Theme.
	 *
	 * @param Media|null $config
	 * @param bool      $getShared
	 *
	 * @return ResetterInterface
	 */
	public static function media(Media $config = null, bool $getShared = true): Media
	{
		if ($getShared)
		{
			return self::getSharedInstance('media', $config);
		}

		return new Media($config ?? config('Media'));
	}

	
}