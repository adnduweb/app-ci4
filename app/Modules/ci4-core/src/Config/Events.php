<?php 

namespace Adnduweb\Ci4Core\Config;

use CodeIgniter\Events\Events;
use Adnduweb\Ci4Core\Core\BaseWhoopsHandler;

/**
 * Detect event on pre system.
 */
Events::on('pre_system', function () {
    if (ENVIRONMENT !== 'production') {
        $config = Config('Whoops')->settings;
        $whoops = new BaseWhoopsHandler($config);
        $whoops->run();
    }
});


Events::on('post_controller_constructor', function () {
	// Ignore CLI requests
	return is_cli() ?: service('visits')->record();
});

Events::on('post_system', function () {
	service('audits')->save();
});
