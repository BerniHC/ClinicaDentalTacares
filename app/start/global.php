<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

$logFile = 'log'.'.txt';
Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function($exception, $code)
{
    Log::error($exception);
    
    if (Config::get('app.debug')) {
    	return;
    }

    return Response::view('error', array('error' => $code), $code);
});

App::missing(function($exception)
{
    Log::error($exception);
    
    if (Config::get('app.debug')) {
    	return;
    }

    return Response::view('error', array('error' => 404), 404);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
    if (Config::get('app.debug')) {
    	return;
    }

    return Response::view('error', array('error' => 503), 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';



/*
|--------------------------------------------------------------------------
| Custom Validations
|--------------------------------------------------------------------------
*/
Validator::extend('has', function($attr, $value, $params) {
    if (!count($params)) {
        throw new \InvalidArgumentException('The has validation rule expects at least one parameter, 0 given.');
    }
    
    foreach ($params as $param) {
        switch ($param) {
            case 'num':
                $regex = '/\pN/';
                break;
            case 'letter':
                $regex = '/\pL/';
                break;
            case 'lower':
                $regex = '/\p{Ll}/';
                break;
            case 'upper':
                $regex = '/\p{Lu}/';
                break;
            case 'special':
                $regex = '/[\pP\pS]/';
                break;
            default:
                $regex = $param;
        }
        
        if (! preg_match($regex, $value)) {
            return false;
        }
    }
    
    return true;
});


/*
|--------------------------------------------------------------------------
| Custom Macros
|--------------------------------------------------------------------------
*/