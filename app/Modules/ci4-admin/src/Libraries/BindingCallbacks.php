<?php

namespace Adnduweb\Ci4Admin\Libraries;

  
class BindingCallbacks{
  
    public static function before_controller(){
      
        //echo "pre_system running - when application initializes";
    }

    public static function after_controller_constructor(){
      
        //echo "post_controller_constructor running - After Controller's constructor but before any method";
    }

    public static function before_method(){
      
        //echo "pre_system running - after complete page load";
    }

    public static function user_update($user){
      
        //echo "pre_system running - after complete page load";
    }
    
}