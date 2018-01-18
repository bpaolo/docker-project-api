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
//Ativos
$router->group(['prefix' => 'ativos'], function () use ($router) {
    $router->post('sync/movimentacao', ['as'=>'Movimentacao',      'uses'=>'AtivosController@Movimentacao']);
    $router->get('async/teste',        ['as'=>'Teste',             'uses'=>'AtivosController@Teste']);
    $router->get('sync/cancelamento',  ['as'=>'Cancelamento',      'uses'=>'AtivosController@Cancelamento']);
});

