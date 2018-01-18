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
//Seminovos
$router->group(['prefix' => 'seminovos'], function () use ($router) {
    $router->post('sync/criar-pedido', 					['as'=>'CriarPedidoAtivo', 'uses'=>'SeminovosController@CriarPedidoAtivo']);
    $router->post('sync/atualiza-status-veiculo',		['as'=>'AtualizaStatusVeiculo', 'uses'=>'SeminovosController@AtualizaStatusVeiculoEntregue']);
    $router->post('sync/atualiza-status-finalizado', 	['as'=>'AtualizaStatusFinalizado', 'uses'=>'SeminovosController@AtualizaStatusFinalizado']);
});
 
