<?php

namespace App\Http\Controllers;

// Helpers

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;
use App\Requests\Rac\AberturaDeContratoRule;
use App\Requests\Rac\CancelamentoDeContratoRule;
use App\Requests\Rac\EncerramentoDeContratoRule;
use App\Requests\Rac\EnviaMaterialRule;
// Consumers
use App\Consumers\Rac\AberturaDeContratoConsumer;
use App\Consumers\Rac\EncerramentoDeContratoConsumer;
use App\Consumers\Rac\OrdemServicoConsumer;
//Publishers
use App\Publishers\Rac\AberturaDeContratoPublisher;
use App\Publishers\Rac\EncerramentoDeContratoPublisher;
use App\Publishers\Rac\EnviaMaterialPublisher;

use App\Publishers\Rac\CancelamentoDeContratoPublisher;
use App\Publishers\Rac\OrdemServicoPublisher;
//Models
use App\Models\ModelLogs;

class RacController extends Controller
{
    /**
     * Envia Abertura de Contrato no SAP.
     *
     * @param
     *
     * @return
     */
    public function EnviaAberturaDeContrato() {
        // Instancia o Publisher
        $publisher   = new AberturaDeContratoPublisher();
        // Método que recupera o Payload (Banco ou Request) e Envia para a fila
        $integrate   = $publisher->getPayload($array=null);
        //Instancia Resposta
        $response    = new ResponseJson();
        // Verifica se Integrou
        if($integrate) {
            return $response->setResponse(202, null, null);
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Recebe Abertura de Contrato no SAP.
     *
     * @param
     *
     * @return
     */
    public function RecebeAberturaDeContrato() {
        // Instancia o Consumer
        $consumer   = new AberturaDeContratoConsumer();
        // Método que recupera o Payload da Fila e Envia para o SAP
        $integrate  = $consumer->handle($array=null);
        //Instancia Resposta
        $response   = new ResponseJson();
        // Verifica se Integrou
        if($integrate) {
            return $response->setResponse(202, null, null);
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Envia Encerramento de Contrato no SAP.
     *
     * @param
     *
     * @return
     */
    public function EnviaEncerramentoDeContrato() {
        // Instancia o Publisher
        $publisher   = new EncerramentoDeContratoPublisher();
        // Método que recupera o Payload (Banco ou Request) e Envia para a fila
        $integrate   = $publisher->getPayload($array=null);
        //Instancia Resposta
        $response    = new ResponseJson();
        // Verifica se Integrou
        if($integrate) {
            return $response->setResponse(202, null, null);
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Recebe Encerramento de Contrato no SAP.
     *
     * @param
     *
     * @return
     */
    public function RecebeEncerramentoDeContrato() {
        // Instancia o Consumer
        $consumer   = new EncerramentoDeContratoConsumer();
        // Método que recupera o Payload da Fila e Envia para o SAP
        $integrate  = $consumer->handle($array=null);
        //Instancia Resposta
        $response   = new ResponseJson();
        // Verifica se Integrou
        if($integrate) {
            return $response->setResponse(202, null, null);
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Cancelamento de Contrato no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function CancelamentoDeContrato(Request $request) {
        //Instancia Resposta
        $response   = new ResponseJson();
        // Verifica se Integrou
        $valid = RuleRequest::isValid($request->all(), CancelamentoDeContratoRule::$rules );
        // Retorno de Validação do Request
        if($valid){
            return $response->setResponse(400, null, null);
        }
        // Instancia Publisher
        $publisher   = new CancelamentoDeContratoPublisher();
        // Envia Payload para o Publisher
        $integrate  = $publisher->getPayload($request->all());
        // Verifica se Integrou
        if($integrate) {
            return $response->setResponse(202, null, null);
        }
        return $response->setResponse(500, null, null);
    }

    /**
     * Envia Abertura de Contrato no SAP.
     *
     * @param
     *
     * @return
     */
    public function EnviaOrdemServico() {
        // Instancia o Publisher

        $publisher   = new OrdemServicoPublisher();
        // Método que recupera o Payload (Banco ou Request) e Envia para a fila
        $integrate   = $publisher->fetch($array=null);
        return $integrate;
    }

    /**
     * Recebe a ordem de serviço para envio no SAP.
     *
     * @param
     *
     * @return
     */
    public function RecebeOrdemServico() {

        // Instancia o Consumer
        $consumer   = new OrdemServicoConsumer();
        // Método que recupera o Payload da Fila e Envia para o SAP
        $integrate  = $consumer->handle($array=null);
        return $integrate;
    }

    public function EnviaMaterial(Request $request) {

        // Instancia Response
        $response  = new ResponseJson();
        // Valida se a Request é Válida
        $valid     = RuleRequest::isValid($request->all(), EnviaMaterialRule::$rules);
        // Retorno da Validação do Request
        if ($valid) {
            return $response->setResponse(400, $valid, null);
        }
        // Instancia o publisher
        $publisher  = new EnviaMaterialPublisher();
        // Envia payload para publisher
        $integrate  = $publisher->getPayload($request->all());
        // Verifica a Integração
        if(empty($integrate)) {
            return $response->setResponse(200, null, null);
        }
        return $response->setResponse(500, null, null);
    }


}