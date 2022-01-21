<?php

namespace Adnduweb\Ci4Core\Commands;

use Config\Autoload;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

class Install extends BaseCommand
{
    // protected $group       = 'Adnduweb';
    // protected $name        = 'install:core';
    // protected $description = 'Installation de l\'application.';

     /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Adnduweb';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'adw:install';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Handles initial installation of Adnduweb.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'adw:install';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

     /**
     * Admin of app
     *
     * @var string
     */
    protected $admin = 'admin';

     /**
     * url of app
     *
     * @var string
     */
    protected $url = 'url';

    /**
     * Actually execute a command.
     */

    public function run(array $params)
    {

        helper('filesystem');

        $this->admin = 'admin' .rand();

        // On vérifie le sytème et les droit écriture
        $this->checkApp();

        $this->ensureEnvFile();
        $this->setAppUrl();
        $this->setSession();
        $this->setCookie();
        $this->setDatabase();
        $this->migrate();
        $this->seeder();
        CLI::write('Done. You can now login as a superadmin : '.$this->url. env('app.areaAdmin').' : admin@admin.com / 123456.', 'green');

        CLI::newLine();

    }

     /**
     * Copies the env file, if .env does not exist
     */
    private function ensureEnvFile()
    {
        CLI::print('Creating .env file...', 'yellow');

        if (file_exists(ROOTPATH . '.env')) {
            CLI::print('Exists', 'green');

            return;
        }

        if (! file_exists(ROOTPATH . 'env')) {
            CLI::error('The original `env` file is not found.');

            exit();
        }

        // Create the .env file
        if (! copy(ROOTPATH . 'env', ROOTPATH . '.env')) {
            CLI::error('Error copying the env file');
        }

        CLI::print('Done', 'green');

        CLI::write('Setting initial environment', 'yellow');

        // Set to development environment
        $this->updateEnvFile('# CI_ENVIRONMENT = production', 'CI_ENVIRONMENT = development');
    }


    public function checkApp()
    {
        CLI::write('PHP Version: ' . CLI::color(phpversion(), 'yellow'));
        CLI::write('CI Version: ' . CLI::color(\CodeIgniter\CodeIgniter::CI_VERSION, 'yellow'));
        CLI::write('APPPATH: ' . CLI::color(APPPATH, 'yellow'));
        CLI::write('SYSTEMPATH: ' . CLI::color(SYSTEMPATH, 'yellow'));
        CLI::write('ROOTPATH: ' . CLI::color(ROOTPATH, 'yellow'));
        CLI::write('Included files: ' . CLI::color(count(get_included_files()), 'yellow'));

        if (!is_writable(ROOTPATH . 'writable/cache/'))
            CLI::write(CLI::color('cache not writable: ', 'red') .  ROOTPATH . 'writable/cache/');
        else
            CLI::write(CLI::color('cache writable: ', 'yellow') .  ROOTPATH . 'writable/cache/');

        if (!is_writable(ROOTPATH . 'writable/logs/'))
            CLI::write(CLI::color('Logs not writable: ', 'red') .  ROOTPATH . 'writable/logs/');
        else
            CLI::write(CLI::color('Logs writable: ', 'yellow') .  ROOTPATH . 'writable/logs/');

        if (!is_writable(ROOTPATH . 'writable/uploads/'))
            CLI::write(CLI::color('Uploads not writable: ', 'red') .  ROOTPATH . 'writable/uploads/');
        else
            CLI::write(CLI::color('Uploads writable: ', 'yellow') .  ROOTPATH . 'writable/uploads/');

        try {
            if (
                phpversion() >= '7.2' &&
                extension_loaded('intl') &&
                extension_loaded('curl') &&
                extension_loaded('json') &&
                extension_loaded('mbstring') &&
                extension_loaded('mysqlnd') &&
                extension_loaded('xml')
            ) {
                //silent
            }
        } catch (\Exception $e) {
            CLI::write('Erreur avec une extension php : ' . CLI::color($e->getMessage(), 'red'));
            exit;
        }

        $continue = CLI::prompt('Voulez vous continuer?', ['y', 'n']);
        if ($continue == 'n') {
            CLI::error('Au revoir');
            exit;
        }
    }

    private function setAppUrl()
    {
        CLI::newLine();
        $this->url = CLI::prompt('What URL are you running Adnduweb under locally?');
        $this->updateEnvFile("# app.baseURL = ''", "app.baseURL = '".$this->url."'");
        $this->updateEnvFile("# app.areaAdmin = ''", "app.areaAdmin = '".$this->admin."'");
        $this->updateEnvFile("# app.indexPage = ''", "app.indexPage = ''");
        $this->updateEnvFile("# app.defaultLocale = 'fr'", "app.defaultLocale = 'fr'");
        $this->updateEnvFile("# app.negotiateLocale = 'false'", "app.negotiateLocale = 'false'");
        $this->updateEnvFile("# app.appTimezone = 'Europe/Paris'", "app.appTimezone = 'Europe/Paris'");

    }

    private function setDatabase()
    {
        $host   = CLI::prompt('Database host:', '127.0.0.1');
        $name   = CLI::prompt('Database name:', 'adnduweb');
        $user   = CLI::prompt('Database username:', 'root');
        $pass   = CLI::prompt('Database password:', 'root');
        $driver = CLI::prompt('Database driver:', ['MySQLi', 'Postgre', 'SQLite']);
        $prefix = CLI::prompt('Table prefix:');

        $this->updateEnvFile('# database.default.hostname = localhost', "database.default.hostname = {$host}");
        $this->updateEnvFile('# database.default.database = ci4', "database.default.database = {$name}");
        $this->updateEnvFile('# database.default.username = root', "database.default.username = {$user}");
        $this->updateEnvFile('# database.default.password = root', "database.default.password = {$pass}");
        $this->updateEnvFile('# database.default.DBDriver = MySQLi', "database.default.DBDriver = {$driver}");
        $this->updateEnvFile('# database.default.DBPrefix =', "database.default.DBPrefix = {$prefix}");

        $this->updateEnvFile('# encryption.driver = OpenSSL', "encryption.driver = OpenSSL");
        $this->updateEnvFile('# encryption.blockSize = 16', "encryption.blockSize = 16");
        $this->updateEnvFile('# encryption.digest = SHA512', "encryption.digest = SHA512");

        command('key:generate hex2bin');
    }

    private function setSession(){

        $this->updateEnvFile("# app.sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler'", "app.sessionDriver = 'Adnduweb\Ci4Core\Session\Handlers\DatabaseHandler'");
        $this->updateEnvFile("# app.sessionCookieName = 'ci_session'", "app.sessionCookieName = 'adn_".rand()."'");
        $this->updateEnvFile('# app.sessionExpiration = 7200', "app.sessionExpiration = '86400'");
        $this->updateEnvFile('# app.sessionSavePath = null', "app.sessionSavePath = 'sessions'");
        $this->updateEnvFile('# app.sessionMatchIP = false', "app.sessionMatchIP = true");
        $this->updateEnvFile('# app.sessionTimeToUpdate = 300', "app.sessionTimeToUpdate = 300");
        $this->updateEnvFile('# app.sessionRegenerateDestroy = false', "app.sessionRegenerateDestroy = true"); 
    }

    private function setCookie(){

        $this->updateEnvFile("# security.csrfProtection = 'cookie'", "security.csrfProtection = 'cookie'");
        $this->updateEnvFile("# security.tokenRandomize = false", "security.tokenRandomize = false");
        $this->updateEnvFile("# security.tokenName = 'csrf_token_name'", "security.tokenName = 'csrf_token_name'");
        $this->updateEnvFile("# security.headerName = 'X-CSRF-TOKEN'", "security.headerName = 'X-CSRF-TOKEN'");
        $this->updateEnvFile("# security.cookieName = 'csrf_cookie_name'", "security.cookieName = 'adn_".rand()."'");
        $this->updateEnvFile("# security.expires = 7200", "security.expires = 7200");
        $this->updateEnvFile("# security.regenerate = true", "security.regenerate = false");
        $this->updateEnvFile("# security.redirect = true", "security.redirect = true");
        $this->updateEnvFile("# security.samesite = 'Lax'", "security.samesite = 'Lax'");

    }

    private function migrate()
    {
        command('migrate --all');
        CLI::newLine();
    }

    private function seeder()
    {
        //command('db:seed Adnduweb\\Ci4Core\\Database\\Seeds\\InitializeCore');
        \Config\Database::seeder()->call('\\Adnduweb\\Ci4Core\\Database\\Seeds\\InitializeCore');
        CLI::newLine();
    }

    /**
     * Replaces text within the .env file.
     */
    private function updateEnvFile(string $find, string $replace)
    {
        $env = file_get_contents(ROOTPATH . '.env');
        $env = str_replace($find, $replace, $env);
        write_file(ROOTPATH . '.env', $env);
    }

}
