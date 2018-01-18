<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Validator;
use App\Responses\ResponseJson;
//Rules
use App\Requests\RuleRequest;
use App\Requests\DadosCreditoRule;
//Consumers
use App\Consumers\CentroCustosConsumer;
//Models
use App\Models\ModelFrota;

// Client
use App\Interfaces\SapClientInterface;

class CreditoController extends Controller
{
    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Limite(Request $request) {
        // Instancia Response
        $response   = new ResponseJson();
        // Valida se a Request é Válida
        $naoValidou = RuleRequest::isValid($request->all(), DadosCreditoRule::$rules );
        // Retorno da Validação do Request
        if($naoValidou){
            return $response->setResponse(400, null, null);
        }
        // envia para o SAP ?
        $integrate = SapClientInterface::send(DadosCreditoRule::parse($request->all()), DadosCreditoRule::$endpoint);
        // Verifica a integração 
        if($integrate) {
            return $response->setResponse(201, null, json_encode($integrate));
        }
        return $response->setResponse(500, null, null);
    }
}