<?php 

namespace Adnduweb\Ci4Admin\Config;

use CodeIgniter\Events\Events;
use Adnduweb\Ci4Admin\Libraries\BindingCallbacks;


$bindingCallbacks = new BindingCallbacks; // Create an instance of MyClass

// Binding class methods as event callbacks

Events::on("pre_system", [$bindingCallbacks, "before_controller"]);

Events::on("post_controller_constructor", [$bindingCallbacks, "after_controller_constructor"]);

Events::on("post_system", [$bindingCallbacks, "before_method"]);

Events::on('user_update', [$bindingCallbacks, "user_update"]);