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
    return '<h1 style="text-align: center; margin: 20% 0;">Kevin<br><img style="width: 150px; margin: 0 auto;" src="https://s-media-cache-ak0.pinimg.com/originals/ee/87/f7/ee87f713215684485f47393d2abab711.png" /></h1>';
});
// API BASE
$router->group(['prefix' => '/v1/'], function () use ($router) {
    // API Auth Basic
    $router->group(['prefix' => 'auth'], function () use ($router) {
        // API LOGIN
        $router->post('login', ['as'=>'login',		'uses'=>'AuthController@login']);
        // API Auth JWT
        $router->group(['middleware' => 'auth:api'], function () use ($router) {
            $router->post('refresh', ['as'=>'refresh', 'uses'=>'AuthController@refresh']);
            $router->post('logout',  ['as'=>'logout', 'uses'=>'AuthController@logout']);
            $router->post('me',      ['as'=>'me', 'uses'=>'AuthController@me']);
        });
    });
    // Auth:api
    $router->group(['middleware' => 'auth:api'], function () use ($router) {
        
        // Seminovos
        require(base_path() . '/routes/seminovos.php');
        // Rent a Car
        require(base_path() . '/routes/rac.php');
        // Ativos
        require(base_path() . '/routes/ativos.php');
        // SIC
        require(base_path() . '/routes/sic.php');
    });
    // Zen
    $router->group(['prefix' => 'zen'], function () use ($router) {
        $router->get('sync/movimentacao',  ['as'=>'Movimentacao',      'uses'=>'AtivosController@Movimentacao']);
        $router->get('async/teste',        ['as'=>'Teste',             'uses'=>'AtivosController@Teste']);
        $router->get('sync/cancelamento',  ['as'=>'Cancelamento',      'uses'=>'AtivosController@Cancelamento']);
        $router->get('sync/centrocustos',  ['as'=>'CentroCustos',      'uses'=>'CentroController@Cadastro']);
        $router->get('sync/dadoscredito',  ['as'=>'DadosCredito',      'uses'=>'CreditoController@Limite']);
    });
    // Landmark
    $router->group(['prefix' => 'landmark'], function () use ($router) {
        $router->get('sync',  ['as'=>'Sync',    'uses'=>'LandmarkController@Sync']);
        $router->get('async', ['as'=>'Async',   'uses'=>'LandmarkController@Async']);
        $router->post('sync', ['as'=>'Sync',    'uses'=>'LandmarkController@Sync']);
        $router->post('async',['as'=>'Async',   'uses'=>'LandmarkController@Async']);

        $router->post('i001',['as'=>'I001',   'uses'=>'LandmarkController@I001']);
        $router->post('i004',['as'=>'I004',   'uses'=>'LandmarkController@I004']);
        $router->post('i012',['as'=>'I012',   'uses'=>'LandmarkController@I012']);
        $router->post('i013',['as'=>'I013',   'uses'=>'LandmarkController@I013']);
        $router->post('i014',['as'=>'I014',   'uses'=>'LandmarkController@I014']);
        $router->post('i019',['as'=>'I019',   'uses'=>'LandmarkController@I019']);
        $router->post('i023',['as'=>'I023',   'uses'=>'LandmarkController@I023']);

        //require(base_path() . '/routes/response.php');

    });
});