<?php 

namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Config\BaseConfig;

class Admin extends BaseConfig
{
	public $name = 'doudouTony';

	/**
	 * Directory to store files (with trailing slash)
	 *
	 * @var string
	 */
	public $resourcesPath = ROOTPATH . 'public/backend/themes/';

    // Tables to ignore when creating the schema
	public $ignoredTables = ['migrations'];
	
	// Namespaces to ignore (mostly for ModelHandler)
	public $ignoredNamespaces = [
		'Tests\Support',
		'CodeIgniter\Commands\Generators',
	];
	
		/**
	 * --------------------------------------------------------------------------
	 * Default TTL
	 * --------------------------------------------------------------------------
	 *
	 * The default number of seconds to save items when none is specified.
	 *
	 * WARNING: This is not used by framework handlers where 60 seconds is
	 * hard-coded, but may be useful to projects and modules. This will replace
	 * the hard-coded value in a future release.
	 *
	 * @var integer
	 */
	public $ttl = 7200;

    
}

