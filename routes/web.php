<?php

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
$router->post('jie','Openssl\JieController@jie');
$router->post('ssl','Openssl\JieController@ssl');
$router->post('feis','Openssl\JieController@feis');
$router->post('jies','Openssl\JieController@jies');
$router->post('yans','Openssl\JieController@yans');
$router->post('regs','User\UserController@regs');
$router->post('logs','User\UserController@logs');
$router->post('reg','User\UsersController@reg');
$router->options('login', function () use ($router) {
    return [];
});
$router->post('login','User\UsersController@login');
//$router->post('center','User\UsersController@center')->middleware('token');

$router->get('center', ['middleware' => 'token', function () {
    //
    'UsersController@center';
}]);