<?php 

namespace Adnduweb\Ci4Core\Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Session\SessionInterface;
use Adnduweb\Ci4Core\Models\LanguageModel;

use Adnduweb\Ci4Core\Config\ImageManger as ImageMangerConfig;
use Adnduweb\Ci4Core\Core\BaseImageManger;

use Adnduweb\Ci4Core\Core\BaseVisits;

use Adnduweb\Ci4Core\Config\Settings as SettingsConfig;
use Adnduweb\Ci4Core\Core\BaseSettings;

use Adnduweb\Ci4Core\Core\BaseAudits;
use Adnduweb\Ci4Core\Config\Audits as AuditsConfig;

class Services extends BaseService
{


	/**
     * Returns the Settings manager class.
     */
    public static function settings(?SettingsConfig $config = null, bool $getShared = true): BaseSettings
    {
        if ($getShared) {
            return static::getSharedInstance('settings', $config);
        }

        /** @var SettingsConfig $config */
        $config = $config ?? config('Settings');

        return new BaseSettings($config);
	}
	
	/**
	 * @param AuditsConfig|null $config
	 * @param bool $getShared
	 *
	 * @return Audits
	 */
    public static function audits(AuditsConfig $config = null, bool $getShared = true): BaseAudits
    {
		if ($getShared)
		{
			return static::getSharedInstance('audits', $config);
		}

		// If no config was injected then load one
		if (empty($config))
		{
			$config = config('Audits');
		}

		return new BaseAudits($config);
	}

	/**
	 * Returns an instance of the ImageManger library
	 * using the specified configuration.
	 *
	 * @param ImageMangerConfig|null $config
	 * @param boolean               $getShared
	 *
	 * @return ImageManger
	 */
	public static function imageManger(ImageMangerConfig $config = null, bool $getShared = true) : BaseImageManger
	{
		if ($getShared)
		{
			return static::getSharedInstance('imageManger', $config);
		}

		return new BaseImageManger($config ?? config('ImageManger'));
	}


	public static function LanguageOverride(BaseConfig $config = null,  Model $LanguageModel = null, bool $getShared = true)
	{
		if ($getShared) {
			return static::getSharedInstance('LanguageOverride', $config, $LanguageModel);
		}

		$instance = new \Adnduweb\Ci4Core\Core\Language($config);

        if (empty($LanguageModel)) {
            $LanguageModel = new LanguageModel();
        }


		// If no config was injected then load one
		if (empty($config)) {
			$config = config('LanguageOverride');
		}

		return $instance->setLanguageModel($LanguageModel);
	}

	public static function visits(BaseConfig $config = null, bool $getShared = true)
    {
		if ($getShared):
			return static::getSharedInstance('visits', $config);
		endif;

		// If no config was injected then load one
		// Prioritizes app/Config if found
		if (empty($config))
			$config = config('Visits');

		return new BaseVisits($config);
	}

	// public static function currency(BaseConfig $config = null, bool $getShared = true)
	// {
	// 	if ($getShared) {
	// 		return static::getSharedInstance('currency', $config);
	// 	}

	// 	// If no config was injected then load one
	// 	if (empty($config)) {
	// 		$config = config('Currency');
	// 	}

	// 	return new \Adnduweb\Ci4Core\Core\BaseCurrency($config);
	// }

	public static function getSecretKey(){
		return getenv('JWT_SECRET_KEY');
	} 

}
