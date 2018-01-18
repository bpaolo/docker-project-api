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
//Rent a Car
$router->group(['prefix' => 'rac'], function () use ($router) {
    // Cancelamento de Contrato
    $router->post('sync/cancelamento-contrato',        ['as'=>'CancelamentoDeContrato', 'uses'=>'RacController@CancelamentoDeContrato']);
    //Abertura do Contrato
    $router->get('async/abertura-contrato-envia',       ['as'=>'EnviaAberturaDeContrato', 'uses'=>'RacController@EnviaAberturaDeContrato']);
    $router->get('async/abertura-contrato-recebe',      ['as'=>'RecebeAberturaDeContrato', 'uses'=>'RacController@RecebeAberturaDeContrato']);
    //Encerramento do Contrato
    $router->get('async/encerramento-contrato-envia',   ['as'=>'EnviaEncerramentoDeContrato', 'uses'=>'RacController@EnviaEncerramentoDeContrato']);
    $router->get('async/encerramento-contrato-recebe',  ['as'=>'RecebeEncerramentoDeContrato', 'uses'=>'RacController@RecebeEncerramentoDeContrato']);
    //Atualização de Pagamento por Boleto
    $router->post('async/atualiza-pagamento-boleto', 	['as'=>'AtualizaPagamento', 'uses'=>'AtualizaPagamentoController@AtualizaPagamento']);
    //Atualização de Caixa
    $router->post('async/atualiza-caixa', 				['as'=>'AtualizaCaixa', 'uses'=>'AtualizaCaixaController@AtualizaCaixa']);
    //Ordem de Serviços
    $router->get('async/ordem-servico-envia',       ['as'=>'EnviaOrdemServico', 'uses'=>'RacController@EnviaOrdemServico']);
    $router->get('async/ordem-servico-recebe',      ['as'=>'RecebeOrdemServico', 'uses'=>'RacController@RecebeOrdemServico']);
    //Materiais
    $router->post('sync/material-envia', 				['as'=>'EnviaMaterial', 'uses'=>'RacController@EnviaMaterial']);
});