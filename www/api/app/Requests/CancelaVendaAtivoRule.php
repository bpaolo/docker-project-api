<?php

namespace App\Requests;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class CancelaVendaAtivoRule 
{
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpointSAP = 'CancelamentoVendaAtivo_I021';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [ 
        'vbeln_va'      => 'required',
        'zzanln1'       => 'required'
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
                'GUID'     => $guid,
                'VBELN_VA' => $array['vbeln_va'],
                'ZZANLN1'  => $array['zzanln1']
            ];
        }
        return $data;
    }
}