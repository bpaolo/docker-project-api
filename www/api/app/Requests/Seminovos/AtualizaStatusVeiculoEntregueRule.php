<?php

namespace App\Requests\Seminovos;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class AtualizaStatusVeiculoEntregueRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I020';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'AtualizaStVeiculoEntregue_I020';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [
        'vbeln' => 'required',
        'mvgr1' => 'required'
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
                "GUID"  => $guid,
                'VBELN' => $array['vbeln'],
                'MVGR1' => $array['mvgr1']
            ];
            return $data;
        }
        return false;
    }
}