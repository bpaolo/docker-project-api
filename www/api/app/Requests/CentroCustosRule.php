<?php

namespace App\Requests;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class CentroCustosRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I024';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'CamposMovAtivo_I024';
    /* 
     * Regras de Validação REST
     */
    public static $rules =  [ 
        'kostl'     => '',
        'eliminado' => '',
        'datab'     => '',
        'datai'     => '',
        'bukrs'     => '',
        'gsber'     => '',
        'kosar'     => '',
        'ktext'     => '',
        'verak'     => '',
        'prctr'     => '',
        'waers'     => '',
        'ltext'     => '',
        'name3'     => '',
        'name4'     => '',
        'telx1'     => '',
        'bkzkp'     => '',
        'bkzks'     => ''
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($array) {
        if ($array) {

            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $data = [
                "GUID"          => $guid,
                "CENTRO_LUCROS"   =>
                    [
                        "KOSTL"     => $guid,
                        "ELIMINADO" => $array['eliminado']??"",
                        "DATAB"     => $array['datab']??"",
                        "DATAI"     => $array['datai']??"",
                        "BUKRS"     => $array['bukrs']??"",
                        "GSBER"     => $array['gsber']??"",
                        "KOSAR"     => $array['kosar']??"",
                        "KTEXT"     => $array['ktext']??"",
                        "VERAK"     => $array['verak']??"",
                        "PRCTR"     => $array['prctr']??"",
                        "WAERS"     => $array['waers']??"",
                        "LTEXT"     => $array['ltext']??"",
                        "NAME3"     => $array['name3']??"",
                        "NAME4"     => $array['name4']??"",
                        "TELX1"     => $array['telx1']??"",
                        "BKZKP"     => $array['bkzkp']??"",
                        "BKZKS"     => $array['bkzks']??""
                    ]
            ];
        }
        return $data;
    }
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parseDB($array) {
        if ($array) {
            
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $status = '';

            switch ($array->StatusID){
                case 1:
                    $status = 'PIMP';
                    break;
                case 2:
                    $status = 'OPEP';
                    break;
                case 3:
                    $status = 'DV';
                    break;
                case 4:
                    $status = 'ROUB';
                    break;
                default:
                    $status = '';
                    break;
            }

            $data = [
                'GUID' => $guid,
                'IMOBILIZADO' =>
                    [
                        'TRANSACAO' => $array->FrotaID,
                        'CHASSI'    => $array->Chassi,
                        'EMPRESA'   => 9000
                    ],
                'ITEM_IMOBILIZADO' => [
                    'TRANSACAO'  => $array->FrotaID,
                    'FILIAL'     => $array->L001_FilialID??'',// gtf
                    'PLACA'      => $array->Placa??'',
                    'STATUS'     => $status??'',
                    'RENAVAM'    => $array->Renavam??'',
                    "CID_EMPLAC" => 'Validar?'??''
                ]
            ];
        }
        return $data;
    }
}