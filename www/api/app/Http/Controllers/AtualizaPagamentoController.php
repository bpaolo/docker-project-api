<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;
use App\Requests\AtualizaPagamentoRule;
// Publishers
use App\Publishers\AtualizaPagamentoPublisher;

class AtualizaPagamentoController extends Controller
{
    public function AtualizaPagamento(Request $request) {
        // Instancia Response
        $response  = new ResponseJson();
        // Valida se a Request é válida
        $valid     = RuleRequest::isValid($request->all(), AtualizaPagamentoRule::$rules);
        // Retorna Validação do Request
        if ($valid) {
            return $response->setResponse(400, $valid, null);
        }
        // Instancia Publisher
        $publisher  = new AtualizaPagamentoPublisher();
        $integrate     = $publisher->getPayload($request->all());
        // Verifica integração
        if(empty($integrate)) {
            return $response->setResponse(200, null, null);
        }
        return $response->setResponse(500, null, null);
    }
}