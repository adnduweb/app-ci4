# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [the announcement](http://forum.codeigniter.com/thread-62615.html) on the forums.

The user guide corresponding to this version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use Github issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)


## FABRICE

php spark migrate -all  
php spark key:generate hex2bin     
npm run dev --admin 
php spark migrate:rollback
php spark db:seed \\Adnduweb\\Ci4Core\\Database\\Seeds\\InitializeCore
php spark list
composer update --no-dev
php spark cache:clear --no-header


## JS
https://grafikart.fr/tutoriels/alpinejs-1944
https://alpinejs.dev/


################################

$result= $this->builder() .... ->get()->getResultArray();



save cache

  cache()->save("{$cachename}", $found, 300);



load cache

$result= cache("{$cachename}")


... function ...

if ( null === ($result= cache("{$cachename}")))
{

  $result= $this->builder() .... ->get()->getResultArray(); // do query

  cache()->save("{$cachename}", $found, 300); //save to cache

}

return $result;

## Gestion Multilingue CodeIgniter
https://includebeer.com/fr/blog/creation-dun-site-web-multilingue-avec-codeigniter-4-partie-1
https://onlinewebtutorblog.com/codeigniter-4-language-localization-multilanguage-site-tutorial/
https://includebeer.com/fr/blog/creation-dun-site-web-multilingue-avec-codeigniter-4-partie-1

## CORS
https://forum.codeigniter.com/thread-80043.html?highlight=redirect


## API
https://www.positronx.io/codeigniter-rest-api-tutorial-with-example/
https://www.twilio.com/blog/create-secured-restful-api-codeigniter-php
https://onlinewebtutorblog.com/codeigniter-4-complete-events-tutorial/
https://www.twilio.com/blog/create-secured-restful-api-codeigniter-php
https://www.positronx.io/codeigniter-rest-api-tutorial-with-example/
https://samsonasik.wordpress.com/2018/09/22/create-api-service-in-codeigniter-4-with-request-filtering/
https://samsonasik.wordpress.com/category/tutorial-php/codeigniter-4/

https://www.twilio.com/blog/create-secured-restful-api-codeigniter-php
https://mfikri.com/en/blog/codeigniter-login-jwt
https://onlinewebtutorblog.com/codeigniter-4-restful-apis-with-jwt-authentication/
https://forum.codeigniter.com/thread-80260.html

<!-- // use \Adnduweb\Ci4Core\Traits\Themeable;
// use \Adnduweb\Ci4Admin\Libraries\Theme;
// use \Adnduweb\Ci4Admin\Libraries\Init;
// use \Adnduweb\Ci4Admin\Libraries\Validate;
// use \Adnduweb\Ci4Admin\Libraries\Tools;
// use \Adnduweb\Ci4Admin\Libraries\Breadcrumb;
// use CodeIgniter\HTTP\RedirectResponse;
// use CodeIgniter\Controller;
// use CodeIgniter\HTTP\CLIRequest;
// use CodeIgniter\HTTP\IncomingRequest;
// use CodeIgniter\HTTP\RequestInterface;
// use CodeIgniter\HTTP\ResponseInterface;
// use Psr\Log\LoggerInterface; -->

## Axios
https://ichi.pro/fr/comment-gerer-les-erreurs-d-api-dans-votre-application-web-a-l-aide-d-axios-196999081229621
https://gist.github.com/liamcurry/2597326

## Angular
https://jasonwatmore.com/fr/post/2019/06/10/angular-8-tutoriel-et-exemple-sur-lenregistrement-et-lauthentification-des-utilisateurs
https://www.positronx.io/angular-jwt-user-authentication-tutorial/
https://www.positronx.io/angular-7-httpclient-http-service/


## SASS
https://forum.codeigniter.com/thread-80249.html


## Log Files
file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
