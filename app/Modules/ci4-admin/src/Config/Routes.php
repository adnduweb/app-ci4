<?php

/**
 * --------------------------------------------------------------------------------------
 * Route Backend
 * --------------------------------------------------------------------------------------
 */

$routes->group(CI_AREA_ADMIN, ['namespace' => '\Adnduweb\Ci4Admin\Controllers\Admin', 'filter' => 'login'], function ($routes) {

    // Login
    $routes->get('login', 'AuthenticationController::index', ['as' => 'login-area']);
    $routes->addRedirect('/', 'login-area');
    $routes->post('login', 'AuthenticationController::attemptLogin', ['as' => 'postlogin-area']);
    $routes->get('logout', 'AuthenticationController::doLogout', ['as' => 'doLogout']);
    $routes->post('logout', 'AuthenticationController::doLogout', ['as' => 'doLogout']);

    //2FA
    $routes->get('two-factor-auth-2fa', 'AuthenticationController::displayTwoFactorAuth', ['as' => 'two-factor-auth-2fa']);
    $routes->post('confirm-two-factor-auth-2fa', 'AuthenticationController::confirmTwoFactorAuth', ['as' => 'confirm-two-factor-auth-2fa']);
    $routes->get('two-factor-auth-2fa-code-recovery', 'AuthenticationController::displayCodeRecovery', ['as' => 'two-factor-auth-2fa-code-recovery']);
    $routes->post('confirm-two-factor-auth-2fa-recovery', 'AuthenticationController::confirmCodeRecovery', ['as' => 'confirm-two-factor-auth-2fa-recovery']);

    // Activation
    $routes->get('activate-account', 'AuthenticationController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthenticationController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot password
    $routes->get('forgot-password', 'AuthenticationController::forgotPassword', ['as' => 'forgot-password']);
    $routes->post('forgot-password', 'AuthenticationController::attemptForgot', ['as' => 'confirm-forgot-password']);

    // Reset password
    $routes->get('reset-password', 'AuthenticationController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthenticationController::attemptReset', ['as' => 'confirm-reset-password']);

    // Dashboard
    $routes->get('dashboard', 'DashboardController::index',  ['as' => 'dashboard']);
    $routes->get('dashboard/mixed-widget-2-chart', 'DashboardController::widgetTwo',  ['as' => 'list-profit-ajax']);

    //$routes->get('cache/(:any)', 'Cache::$1',  ['as' => 'cache-$1']);

    // Réglages système
    $routes->group('settings-advanced/settings', function ($routes) {
        $routes->get('/', 'SettingsController::index', ['as' => 'settings-index']);
        $routes->post('/', 'SettingsController::store');
        $routes->post('genererKeyApi', 'SettingsController::genererKeyApi', ['as' => 'settings-genererkeyapi']);
        $routes->get('update-user', 'SettingsController::updateUser', ['as' => 'settings-update-user']);
    });


    // Users
    $routes->group('settings-advanced/users', function ($routes) {

        $routes->get('/', 'UsersController::index', ['as' => 'users']);
        $routes->get('datatable', 'UsersController::ajaxDatatable', ['as' => 'users-listajax']);

        $routes->get('edit/(:any)', 'UsersController::edit/$2', ['as' => 'user-edit']);
        $routes->post('save', 'UsersController::save', ['as' => 'user-save-detail']);
        $routes->get("create", "UsersController::new", ['as' => 'user-new']);
        $routes->post('create', 'UsersController::create', ['as' => 'user-create']);
        $routes->delete('delete2fa', 'UsersController::detete2Fa', ['as' => 'user-delete-2fa']);
        $routes->get('detete-sessions/(:any)', 'UsersController::deleteSessions/$1', ['as' => 'user-delete-sessions']);
        $routes->post('update-ajax', 'UsersController::updateAjax', ['as' => 'user-update-ajax']);
        $routes->delete('delete', 'UsersController::delete', ['as' => 'user-delete']);
        $routes->post('export', 'UsersController::export', ['as' => 'user-export-ajax']);
        $routes->get('export/(:any)', 'UsersController::export/$1', ['as' => 'user-export']);
        $routes->get("en-tant-que", "UsersController::enTantQue", ['as' => 'user-entantque']);
        $routes->get("list-user", "UsersController::listUser", ['as' => 'user-list-ajax']);
        $routes->post('en-tant-que', 'UsersController::confirmEnTantQue', ['as' => 'user-entantque-comfirm']);
        $routes->get('return-compte-principale/(:any)', 'UsersController::returnCompteUser/$1', ['as' => 'user-return-compte']);
        
        
    });

    //Groups
    $routes->group('settings-advanced/groups', function ($routes) {

        $routes->get('/', 'GroupsController::index', ['as' => 'groups']);
        $routes->get('datatable', 'GroupsController::ajaxDatatable', ['as' => 'groups-listajax']);

        $routes->get('edit/(:any)', 'GroupsController::edit/$2', ['as' => 'group-edit']);
        $routes->post('edit/(:any)', 'GroupsController::update/$2', ['as' => 'groups-update']);
        $routes->get("create", "PermissionsController::new", ['as' => 'group-new']);
        $routes->post('create', 'GroupsController::create', ['as' => 'new-create']);
        $routes->delete('delete', 'GroupsController::delete', ['as' => 'group-delete']);
        $routes->post('export', 'GroupsController::export', ['as' => 'group-export-ajax']);
        $routes->get('export/(:any)', 'GroupsController::export/$1', ['as' => 'group-export']);
        $routes->post('savePermissions', 'GroupsController::savePermissions',  ['as' => 'group-save-permissions']);
        $routes->post('saveAllPermissions', 'GroupsController::saveAllPermissions',  ['as' => 'group-save-all-permissions']);
        $routes->post('saveAllPermissions-users', 'GroupsController::saveAllPermissionsUsers',  ['as' => 'group-save-permissions-users']);
        
    });

    // Permissions
    $routes->group('settings-advanced/permissions', function ($routes) {

        $routes->get('/', 'PermissionsController::index', ['as' => 'permissions']);
        $routes->get('datatable', 'PermissionsController::ajaxDatatable', ['as' => 'permissions-listajax']);

        $routes->get('edit/(:any)', 'PermissionsController::edit/$2', ['as' => 'permission-edit']);
        $routes->post('edit/(:any)', 'PermissionsController::update/$2', ['as' => 'permissions-update']);
        $routes->get("create", "PermissionsController::new", ['as' => 'permission-new']);
        $routes->post('create', 'PermissionsController::create', ['as' => 'permissions-create']);
        $routes->delete('delete', 'PermissionsController::delete', ['as' => 'permission-delete']);
        $routes->post('export', 'PermissionsController::export', ['as' => 'permission-export-ajax']);
        $routes->get('export/(:any)', 'PermissionsController::export/$1', ['as' => 'permission-export']);
    });


    // Logs
    $routes->group('settings-advanced/logs', function ($routes) {

        $routes->get('/', 'LogsController::index', ['as' => 'logs']);
        $routes->get('datatable', 'LogsController::ajaxDatatable', ['as' => 'logs-listajax']);
        $routes->delete('delete', 'LogsController::delete', ['as' => 'log-delete']);
        $routes->post('export', 'LogsController::export', ['as' => 'log-export-ajax']);
        $routes->get('traffics', 'LogsController::indexTraffics', ['as' => 'log-list-traffics']);
        $routes->get('datatable-traffics', 'LogsController::ajaxDatatableTraffics', ['as' => 'logs-traffics-listajax']);
        $routes->get('connexions', 'LogsController::indexConnexions', ['as' => 'log-list-connexions']);
        $routes->get('datatable-connexions', 'LogsController::ajaxDatatableConnexions', ['as' => 'logs-connexions-listajax']);
        $routes->get('files', 'LogsController::indexFiles', ['as' => 'log-list-files']);
        $routes->get('files/(:any)', 'LogsController::viewsFiles/$1', ['as' => 'log-views-files']);
        $routes->post('files/delete-log', 'LogsController::deleteLog', ['as' => 'log-delete-file']);

    });

    // Translate
    $routes->group('settings-advanced/translates', function ($routes) {

        $routes->get('/', 'TranslatesController::index', ['as' => 'translate']);
        $routes->post('getfile', 'TranslatesController::getFile', ['as' => 'translate-getfile']);
        $routes->post('savefile', 'TranslatesController::saveFile', ['as' => 'translate-savefile']);
        $routes->post('deleteTexte', 'TranslatesController::deleteTexte', ['as' => 'translate-deletetexte']);
        $routes->post('searchTexte', 'TranslatesController::searchTexte', ['as' => 'translate-searchtexte']);
        $routes->post('saveTextfile', 'TranslatesController::saveTextfile', ['as' => 'translate-savetextfile']);
        $routes->post('export', 'TranslatesController::export', ['as' => 'translate-export-ajax']);
        $routes->post('import', 'TranslatesController::import', ['as' => 'translate-import-ajax']);
    });

    // Modules
    $routes->group('settings-advanced/modules', function ($routes) {
        $routes->get('/', 'ModulesController::index', ['as' => 'modules']);
        $routes->post('update-ajax', 'ModulesController::updateAjax', ['as' => 'module-update-ajax']);
        $routes->post('module-sync-bdd', 'ModulesController::syncBDD', ['as' => 'module-sync-bdd']);
    });


    //cache
    $routes->get('cache', 'CacheController::clearCache',  ['as' => 'cache']);
    //ChangeLogs
    $routes->get('changelog', 'ChangelogsController::index',  ['as' => 'change-log']);

    // Informations
    $routes->get('(:any)/informations', 'InformationsController::index',  ['as' => 'informations']);
    $routes->get('changelogs', 'ChangelogsController::index',  ['as' => 'change-logs']);
    

    //AJAX
    $routes->group('ajax', function ($routes) {
        $routes->post('ktAsideUser', 'UsersController::ktAsideUser');
        $routes->post('send-mail-account-manager', 'AjaxController::sendMailAccountManager', ['as' => 'send-mail-account-manager']);
       
    });

});

$routes->get('vie-privee', '\Adnduweb\Ci4Admin\Controllers\Pages::viePrivee',  ['as' => 'vie-privee']);
