<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

/**ROUTES WITH AUTH**/
$router->group(['middleware' => 'auth:sanctum'], function () use ($router) {
});

/**ROUTES WITHOUT AUTH**/
$router->get('/[attr]', function ($attr = null) {
    return Controller::get($attr);
});

$router->post('/', function ($request) {
    return Controller::fetch($request);
});

$router->put('/', function ($request) {
    return Controller::put($request);
});

$router->delete('/[attr]', function ($attr = null) {
    return Controller::delete($attr);
});
