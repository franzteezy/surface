<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Controller;

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

$router->post('/', function (Illuminate\Http\Request $request) {
    return Controller::fetch($request);
});

$router->post('/put', function (Illuminate\Http\Request $request) {
    return Controller::put($request);
});

$router->post('/put/forgot-password', function (Illuminate\Http\Request $request) {
    return Controller::forgotPassword($request);
});

$router->post('/put/reset-password', function (Illuminate\Http\Request $request) {
    return Controller::resetPassword($request);
});

/**ROUTES WITH AUTH**/ // TODO: write authentication
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/[{attr}]', function ($attr = null) {
        return Controller::get($attr);
    });

    $router->get('/delete/[attr]', function ($attr = null) {
        return Controller::delete($attr);
    });
});
