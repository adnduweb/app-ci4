<?php

namespace Adnduweb\Ci4Core\Core;


class BaseErrors
{

    public static function show404(){
        // echo 'fabrice';
        // exit;

        helper('admin');
   
       // echo view('Adnduweb\Ci4Admin\Views\themes\\' .service('settings')->get('App.theme_fo', 'name') . '\errors\404', []);
    }


}