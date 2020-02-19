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

$router->group(['prefix' => '/test'], function () use ($router) {
    $router->get('/', 'TestController@test');
    $router->post('/', 'TestController@test');

    $router->get('/1', 'TestController@test1');
    $router->get('/2', 'TestController@test2');
    $router->get('/reset', 'TestController@reset');
});

$router->group(['prefix' => '/user'], function () use ($router) {
    $router->post('/register', 'UserController@register');
    $router->post('/login', 'UserController@login');
    $router->post('/password', 'UserController@password');
    $router->post('/reset', 'UserController@reset');
});

$router->group(['middleware' => 'auth', 'prefix' => '/profile'], function () use ($router) {
    $router->get('/sync', 'ProfileController@sync');
    $router->post('/sync', 'ProfileController@sync');

    $router->get('/location', 'ProfileController@location');
    $router->post('/location', 'ProfileController@location');

    $router->post('/activate', 'ProfileController@activate');
    $router->post('/verify', 'ProfileController@verify');
    $router->post('/nickname', 'ProfileController@nickname');

    $router->post('/update/info', 'ProfileController@update_info');
    $router->post('/update/pass', 'ProfileController@update_pass');
    $router->post('/update/avatar', 'ProfileController@update_avatar');

    $router->post('/update/email', 'ProfileController@update_email');
    $router->post('/verify/email', 'ProfileController@verify_email');

    $router->post('/position', 'ProfileController@position');
});

$router->group(['middleware' => 'auth', 'prefix' => '/order'], function () use ($router) {
    $router->post('/pending', 'OrderController@pending');
    $router->post('/init', 'OrderController@init');
    $router->post('/set_pickup', 'OrderController@set_pickup');
    $router->post('/set_destination', 'OrderController@set_destination');
    $router->post('/details', 'OrderController@details');
    $router->post('/receiver', 'OrderController@receiver');
    $router->post('/set_receiver', 'OrderController@set_receiver');
    $router->post('/show_dispatchers', 'OrderController@show_dispatchers');
});

$router->group(['middleware' => 'auth', 'prefix' => '/actions'], function () use ($router) {
    $router->post('/back', 'ActionsController@back');
    $router->post('/locate', 'ActionsController@locate');
    $router->post('/rate', 'ActionsController@rate');
});

$router->group(['middleware' => 'auth', 'prefix' => '/pickup'], function () use ($router) {
    $router->post('/start', 'PickupController@start');
    $router->post('/deliver', 'PickupController@deliver');
});

$router->group(['middleware' => 'auth', 'prefix' => '/payment'], function () use ($router) {
    $router->post('/make', 'PaymentController@make');
    $router->post('/confirm', 'PaymentController@confirm');
});

$router->group(['middleware' => 'auth', 'prefix' => '/dispatcher'], function () use ($router) {
    $router->post('/accept', 'DispatcherController@accept');
    $router->post('/peek', 'DispatcherController@peek');
    $router->post('/ping', 'DispatcherController@ping');
    $router->post('/update', 'DispatcherController@update');
    $router->post('/track', 'DispatcherController@track');
    $router->post('/list', 'DispatcherController@list');
    $router->post('/select', 'DispatcherController@select');
    $router->post('/job', 'DispatcherController@job');
});

$router->group(['prefix' => '/img'], function () use ($router) {
    $router->get('/users', 'UserController@signup');
});
