<?php

namespace App\Requests\Rac;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class CancelamentoDeContratoRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I014';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'CancelamentoContrato_I014';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [ 
        'vbeln'     => 'required'
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($array) {
        if ($array) {
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $data   = [
                'GUID'      => $guid,
                'VBELN'     => $array['vbeln']
            ];  
        }
        return $data;
    }
}