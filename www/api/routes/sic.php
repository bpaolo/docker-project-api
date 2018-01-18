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
//SIC
$router->group(['prefix' => 'sic'], function () use ($router) {
    $router->get('sync/busca-cliente',              ['as'=>'BuscaCliente',          'uses'=>'SicController@BuscaCliente']);
    $router->get('sync/busca-fornecedor',           ['as'=>'BuscaFornecedor',       'uses'=>'SicController@BuscaFornecedor']);
    $router->post('sync/busca-cliente-documento',   ['as'=>'BuscaClientePorDocumento',   'uses'=>'SicController@BuscaClientePorDocumento']);
    $router->post('sync/busca-fornecedor-documento',   ['as'=>'BuscaFornecedorPorDocumento',   'uses'=>'SicController@BuscaFornecedorPorDocumento']);
});
