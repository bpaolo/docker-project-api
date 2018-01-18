<?php

namespace App\Http\Controllers;
//Helpers
use Illuminate\Http\Request;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;
use App\Requests\AtualizaCaixaRule;
// Publishers
use App\Publishers\AtualizaCaixaPublisher;

class AtualizaCaixaController extends Controller
{
    public function AtualizaCaixa(Request $request) {
        // Instancia Response
        $response  = new ResponseJson();
        // Valida se a Request é Válida
        $valid     = RuleRequest::isValid($request->all(), AtualizaCaixaRule::$rules);
        // Retorno da Validação do Request
        if ($valid) {
            return $response->setResponse(400, $valid, null);
        }
        // Instancia o publisher
        $publisher  = new AtualizaCaixaPublisher();
        // Envia payload para publisher
        $integrate  = $publisher->getPayload($request->all());
        // Verifica a Integração
        if(empty($integrate)) {
            return $response->setResponse(200, null, null);
        }
        return $response->setResponse(500, null, null);
    }
}