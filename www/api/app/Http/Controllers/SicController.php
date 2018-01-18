<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;
use App\Requests\Corporativo\Sic\SicRule;
use App\Requests\Corporativo\Sic\SicClienteDocumentoRule;
use App\Requests\Corporativo\Sic\SicFornecedorDocumentoRule;
// Consumers
use App\Publishers\Corporativo\Sic\BuscaClientePublisher;
use App\Publishers\Corporativo\Sic\BuscaFornecedorPublisher;
use App\Publishers\Corporativo\Sic\BuscaClienteDocumentoPublisher;
use App\Publishers\Corporativo\Sic\BuscaFornecedorDocumentoPublisher;

class SicController extends Controller
{
    /**
     * Busca Cliente no SIC.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscaCliente() { 
        $array['method']        = 'ObterListaCadastrosSIC';
        $array['id_empresa']    = 'MOVIDALOC_DEVEIC_S_A';
        $array['tipo_cadastro'] = 'CLIENTE';
        $consumer               = new BuscaClientePublisher();
        $data                   = $consumer->getPayload($array);
        $response               = new ResponseJson();
        if($data == 'NoContent') {
            $error[] = 'Sem Conteúdo';
            return $response->setResponse(200, $error, null);
        }
        if($data) {
            return $response->setResponse(200, null, json_decode($data));
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Busca Fornecedor no SIC.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscaFornecedor() {
        $array['method']        = 'ObterListaCadastrosSIC';
        $array['id_empresa']    = 'MOVIDALOC_DEVEIC_S_A';
        $array['tipo_cadastro'] = 'FORNECEDOR';
        $consumer               = new BuscaFornecedorPublisher();
        $data                   = $consumer->getPayload($array);
        $response               = new ResponseJson();
        if($data == 'NoContent') {
            $error[] = 'Sem Conteúdo';
            return $response->setResponse(200, $error, null);
        }
        if($data) {
            return $response->setResponse(200, null, json_decode($data));
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Busca Cliente no SIC POR Documento.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscaClientePorDocumento(Request $request) {
        $valid = RuleRequest::isValid($request->all(), SicClienteDocumentoRule::$rules );

        if($valid) {
            return response()->json($valid, 400);
        }
        $array['method']        = 'ObterCadastroSIC';
        $array['id_empresa']    = 'MOVIDALOC_DEVEIC_S_A';
        $array['tipo_cadastro'] = 'CLIENTE';
        $array['tipo_pessoa']   = $request->tipo_pessoa;
        $array['documento']     = $request->documento;
        $consumer               = new BuscaCLienteDocumentoPublisher();
        $data                   = $consumer->getPayload($array);
        $response               = new ResponseJson();
        if($data == 'NoContent') {
            $error[] = 'Sem Conteúdo';
            return $response->setResponse(200, $error, null);
        }
        if($data) {
            return $response->setResponse(200, null, json_decode($data));
        }
        return $response->setResponse(500, null, null);
    }
    /**
     * Busca Fornecedor no SIC POR Documento.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function BuscaFornecedorPorDocumento(Request $request) {
        $valid = RuleRequest::isValid($request->all(), SicFornecedorDocumentoRule::$rules );

        if($valid) {
            return response()->json($valid, 400);
        }
        $array['method']        = 'ObterCadastroSIC';
        $array['id_empresa']    = 'MOVIDALOC_DEVEIC_S_A';
        $array['tipo_cadastro'] = 'FORNECEDOR';
        $array['tipo_pessoa']   = 'PJ';
        $array['documento']     = $request->documento;
        $consumer               = new BuscaFornecedorDocumentoPublisher();
        $data                   = $consumer->getPayload($array);
        $response               = new ResponseJson();
        if($data == 'NoContent') {
            $error[] = 'Sem Conteúdo';
            return $response->setResponse(200, $error, null);
        }
        if($data) {
            return $response->setResponse(200, null, json_decode($data));
        }
        return $response->setResponse(500, null, null);
    }
}