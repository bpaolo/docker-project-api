<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;
use App\Requests\Seminovos\CriacaoPedidoAtivoRule;
use App\Requests\Seminovos\AtualizaStatusVeiculoEntregueRule;
use App\Requests\Seminovos\AtualizaStatusFinanceiroRule;
// Publishers
use App\Publishers\Seminovos\CriacaoPedidoAtivoPublisher;
use App\Publishers\Seminovos\AtualizaStatusVeiculoEntreguePublisher;
use App\Publishers\Seminovos\AtualizaStatusFinanceiroPublisher;


class SeminovosController extends Controller
{
    /**
     * Criar Pedido Ativo no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function CriarPedidoAtivo(Request $request) {
        // Instancia Response;
        $response    = new ResponseJson();
        // Valida se a Request é Válida
        $valid = RuleRequest::isValid($request->all(), CriacaoPedidoAtivoRule::$rules);
        // Retorna erro se algum campo for inválido
        if($valid){
            return $response->setResponse(400, $valid, null);
        }
        //Instancia o Publisher
        $publisher   = new CriacaoPedidoAtivoPublisher();
        //Envia os dados do request para o publisher
        $integrate   = $publisher->getPayload($request->all());
        // Verifica Integração
        if($integrate) {

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;

            if($status == 'S') {
                $docnum = $rsap->RET->KEY->KEYNR;
                $data = [
                    'guid'   => $guid,
                    'docnum' => $docnum
                ];
                return $response->setResponse(201, null, $data);
            }

            if($status == 'E') {
                if(isset($rsap->RET->KEY->RET_LOG->LOG)){
                    $message = $rsap->RET->KEY->RET_LOG->LOG;
                    $data = [
                        'guid'   => $guid
                    ];
                    return $response->setResponse(422, null, $data);
                } 
            }
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Atualizar Status do Veículo Entregue no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AtualizaStatusVeiculoEntregue(Request $request) {
        // Instancia Response;
        $response    = new ResponseJson();
        // Valida se a Request é Válida
        $valid = RuleRequest::isValid($request->all(), AtualizaStatusVeiculoEntregueRule::$rules);
        // Retorna erro se algum campo for inválido
        if($valid) {
            return $response->setResponse(400, $valid, null);
        }
        // Instancia Publisher
        $publisher   = new AtualizaStatusVeiculoEntreguePublisher();
        // 
        $integrate   = $publisher->getPayload($request->all());

        if($integrate) {

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;

            if($status == 'S') {

                $docnum = $rsap->RET->KEY->KEYNR;
                $data = [
                    'guid'   => $guid,
                    'docnum' => $docnum
                ];
                return $response->setResponse(201, null, $data);
            }

            if($status == 'E') {
                if(isset($rsap->RET->KEY->RET_LOG->LOG)) {
                    $message = $rsap->RET->KEY->RET_LOG->LOG;
                    $data = [
                        'guid'   => $guid
                    ];
                    return $response->setResponse(422, null, $data);
                } 
            }
        }

        return $response->setResponse(500, null, null);
    }
    /**
     * Atualizar Status Finalizado no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AtualizaStatusFinalizado(Request $request) {
        // Instancia Response;
        $response    = new ResponseJson();
        // Valida se a Request é Válida
        $valid = RuleRequest::isValid($request->all(), AtualizaStatusFinalizadoRule::$rules );
        // Retorno da Validação do Request
        if($valid){
            return $response->setResponse(400, null, null);
        }
        // Instancia Publisher
        $publisher   = new AtualizaStatusFinalizadoPublisher();
        // Envia Payload para Publisher
        $integrate   = $publisher->getPayload($request->all());
        // Verificar Integração
        if($integrate) {

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;
            // Retorno Sucesso
            if($status == 'S'){

                $docnum = $rsap->RET->KEY->KEYNR;
                $data = [
                    'docnum' => $docnum
                ];
                
                return $response->setResponse(201, null, $data);
            }
            // Retorno Erro
            if($status == 'E') {
                if(isset($rsap->RET->KEY->RET_LOG->LOG)) {
                    $message = $rsap->RET->KEY->RET_LOG->LOG;
                    return $response->setResponse(422, $message, null);
                } 
            }
        }
        return $response->setResponse(500, null, null);
    }
}
