<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * 
 */
// $router->get('update', function() {
//     return 'update';
// });

$router->get('update', 'SdnEntryController@Update');
$router->get('state', 'SdnEntryController@State');
$router->get('get_names', 'SdnEntryController@GetNames');
