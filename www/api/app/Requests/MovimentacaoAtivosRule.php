<?php

namespace App\Requests;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class MovimentacaoAtivosRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I024';
    /* 
     * Regras de Validação REST
     */
    public static $endpoint = 'CamposMovAtivo_I024';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [ 
        'imobilizado_transacao'  => 'required',
        'imobilizado_chassi'     => 'required',
        'imobilizado_empresa'    => 'required',
        'item_transacao'         => 'required',
        'item_filial'            => '',
        'item_placa'             => '',
        'item_status'            => '',
        'item_renavam'           => '',
        "item_cid_emplac"        => ''
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
                "GUID"          => $guid,
                "IMOBILIZADO"   =>
                    [
                        'TRANSACAO' => $array['imobilizado_transacao'],
                        'CHASSI'    => $array['imobilizado_chassi'],
                        'EMPRESA'   => $array['imobilizado_empresa']
                    ],
                "ITEM_IMOBILIZADO"  => [
                        'TRANSACAO'     => $array['item_transacao'],
                        'FILIAL'        => $array['item_filial']??'',
                        'PLACA'         => $array['item_placa']??'',
                        'STATUS'        => $array['item_status']??'',
                        'RENAVAM'       => $array['item_renavam']??'',
                        "CID_EMPLAC"    => $array['item_cid_emplac']??''
                    ]
            ];
        }
        return $data;
    }
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parseDB($dados) {
        if ($dados) {
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $status = '';

            $d['pimp'] = [1,2,3,4,5];
            $d['oper'] = [6,7,8,9,10];
            $d['dven'] = [11,12,13,14];
            $d['roub'] = [15,16,17,18];

            foreach ($d as $key => $value){
                if($status){
                    break;
                }
                foreach ($value as $id){

                    if($id == $dados->StatusID ){
                        $status =  $key;
                        break;
                    }
                }
            }

            $data = [
                "GUID" => $guid,
                "IMOBILIZADO" =>
                    [
                        'TRANSACAO' => $dados->FrotaID,
                        'CHASSI'    => $dados->Chassi,
                        'EMPRESA'   => 9000
                    ],
                "ITEM_IMOBILIZADO"           => [
                    'TRANSACAO'  => $dados->FrotaID,
                    'FILIAL'     => $dados->L001_FilialID??'',
                    'PLACA'      => $dados->Placa??'',
                    'STATUS'     => $status??'',
                    'RENAVAM'    => $dados->Renavam??'',
                    "CID_EMPLAC" => ''
                ]
            ];
        }
        return $data;
    }
}