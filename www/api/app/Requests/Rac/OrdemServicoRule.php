<?php

namespace App\Requests\Rac;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class OrdemServicoRule
{
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'ConsOrdServicoPedCompra_I010';
     /* 
     * Regras de Validação REST
     */
    public static $rules =  [
        'GUID'=> '',
        'TP_PROC'=> '',
        'EBELN'=> '',
        'LIFNR'=> '',
        'TP_ORD_SERV_VETOR'=> '',
        'MATNR'=> '',
        'WERKS'=> '',
        'LGORT'=> '',
        'BEDNR'=> '',
        'MENGE'=> '',
        'NETWR'=> '',
        'MWSKZ'=> '',
        'KNTTP'=> '',
        'KOSTL'=> '',
        'AUFNR'=> ''
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($obj=null) {

        $data = array();
        if ($obj) {

            //Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $data['GUID']       = $guid;
            $data['TP_PROC']    = $obj->TP_PROC;
            $data['EBELN']      = $obj->EBELN;
            $data['LIFNR']      = $obj->LIFNR;
            $data['TP_ORD_SERV_VETOR'] = $obj->TP_ORD_SERV_VETOR;

            $dataJson = '{';
            foreach ($data as $key => $value){
                $dataJson .= '"'.$key.'": "'.$value .'",';
            }
            if(isset($obj->ITEM) && $obj->ITEM !=''){
                $dataJson .= $obj->ITEM;
            };
            $dataJson .= '}';
        }
        return $dataJson;
    }
}