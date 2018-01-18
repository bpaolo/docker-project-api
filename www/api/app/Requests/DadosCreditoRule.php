<?php

namespace App\Requests;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class DadosCreditoRule
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I006';
    /* 
     * Regras de Validação REST
     */
    public static $endpoint = 'DadosCredito_I006';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [ 
        'kunnr'  => 'required',
        'bukrs'  => '',
        'waers'  => ''
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($array) {

        if ($array) {
            $data   = [
                "GUID"   => "6A",
                'KUNNR'  => $array['kunnr'],
                'BUKRS'  => '9000',
                'WAERS'  => 'BR'
            ];
        }
        return $data;
    }
}