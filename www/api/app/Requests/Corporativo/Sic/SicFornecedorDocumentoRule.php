<?php

namespace App\Requests\Corporativo\Sic;

use Validator;

class SicFornecedorDocumentoRule
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = '';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'Integracao/IntegracaoSVC.svc?wsdl';
    /* 
     * Regras de Validação REST
     */
    public static $rules =  [
        'documento'       => 'required'
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($array) {
        if ($array) {
            $data = [
                'method'        => $array['method'],
                'id_empresa'    => $array['id_empresa'],
                'tipo_cadastro' => $array['tipo_cadastro'],
                'tipo_pessoa'   => $array['tipo_pessoa'],
                'documento'     => $array['documento']
            ];
        }
        return $data;
    }
}