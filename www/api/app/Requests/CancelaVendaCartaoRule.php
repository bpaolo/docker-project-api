<?php

namespace App\Requests;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class CancelaVendaCartaoRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I005';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'CancVendaCartao_I005';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [ 
        'cabec_transacao'        => 'required',
        'cabec_data_doc'         => 'required',
        'cabec_tipo_doc'         => 'required',
        'cabec_empresa'          => 'required',
        'cabec_data_lancto'      => 'required',
        'cabec_moeda'            => 'required',
        'cabec_referencia'       => 'required',
        'cabec_texto_cabec'      => 'required',
        'cabec_chave_ref1'       => 'required',
        'cabec_chave_ref2'       => 'required',
        'item_cliente_transacao'        => 'required',
        'item_cliente_cod_cliente'      => 'required',
        'item_cliente_atribuicao'       => 'required',
        'item_cliente_montante'         => 'required',
        'item_cliente_vencto'           => 'required',
        'item_cliente_chave_ref1'       => 'required',
        'item_cliente_chave_ref2'       => 'required',
        'item_cliente_chave_ref3'       => 'required',
        'item_cliente_centro_lucro'     => 'required',
        'item_cliente_divisao'          => 'required',
        'item_cliente_ref_pagto'        => 'required',
        'item_cliente_texto'            => 'required',
        'item_cliente_zlsch'            => '',
        'item_cartao_transacao'         => 'required',
        'item_cartao_cod_cliente'       => 'required',
        'item_cartao_atribuicao'        => 'required',
        'item_cartao_montante'          => 'required',
        'item_cartao_vencto'            => 'required',
        'item_cartao_chave_ref1'        => 'required',
        'item_cartao_chave_ref2'        => 'required',
        'item_cartao_chave_ref3'        => 'required',
        'item_cartao_centro_lucro'      => 'required',
        'item_cartao_divisao'           => 'required',
        'item_cartao_ref_pagto'         => 'required',
        'item_cartao_texto'             => 'required',
        'item_cartao_zlsch'             => ''
    ];

    public static function parse($array) {
        if ($array) {
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $data = [
                'GUID' => $guid,
                'LANCAMENTO' => [
                    'CABEC' => [
                        'TRANSACAO'        => $array['']??'',
                        'DATA_DOC'         => $array['']??'',
                        'TIPO_DOC'         => $array['']??'',
                        'EMPRESA'          => $array['']??'',
                        'DATA_LANCTO'      => $array['']??'',
                        'MOEDA'            => $array['']??'',
                        'REFERENCIA'       => $array['']??'',
                        'TEXTO_CABEC'      => $array['']??'',
                        'CHAVE_REF1'       => $array['']??'',
                        'CHAVE_REF2'       => $array['']??''
                    ],
                    'ITEM_CLIENTE' => [
                        'TRANSACAO'        => $array[''],
                        'COD_CLIENTE'      => $array[''],
                        'ATRIBUICAO'       => $array[''],
                        'MONTANTE'         => $array[''],
                        'VENCTO'           => $array[''],
                        'CHAVE_REF1'       => $array[''],
                        'CHAVE_REF2'       => $array[''],
                        'CHAVE_REF3'       => $array[''],
                        'CENTRO_LUCRO'     => $array[''],
                        'DIVISAO'          => $array[''],
                        'REF_PAGTO'        => $array[''],
                        'TEXTO'            => $array['']
                    ],
                    'ITEM_CARTAO' => [
                        'TRANSACAO'        => $array[''],
                        'COD_CLIENTE'      => $array[''],
                        'ATRIBUICAO'       => $array[''],
                        'MONTANTE'         => $array[''],
                        'VENCTO'           => $array[''],
                        'CHAVE_REF1'       => $array[''],
                        'CHAVE_REF2'       => $array[''],
                        'CHAVE_REF3'       => $array[''],
                        'CENTRO_LUCRO'     => $array[''],
                        'DIVISAO'          => $array[''],
                        'REF_PAGTO'        => $array[''],
                        'TEXTO'            => $array['']
                    ]

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

            $forma = '';

            switch($array[0]['FormaID']){
                case 3:

                    $forma = 'crédito = '.($array[0]['NroParcelas'] > 1)?'Parcelado':'Rotativo';
                    break;
                case 9:
                    $forma = 'débito = á vista';
                    break;
            }

            $data = [
                "GUID" => $guid??1,
                "LANCAMENTO"=> [
                    "CABEC"=> [
                        "TRANSACAO"         => $array[0]['NroLancamento'],
                        "DATA_DOC"         => $array[0]['DTIntegracao'],
                        "TIPO_DOC"         => 'x1',
                        "EMPRESA"          => 9000,
                        "DATA_LANCTO"      => $array[0]['DataLancto'],
                        "MOEDA"            => 'BRL',
                        "REFERENCIA"       => $array[0]['TID']??'',
                        "TEXTO_CABEC"      => $array[0]['BandeiraID']??'' .'/'. $array[0]['Nro2']??'' ,
                        "CHAVE_REF1"       => $array[0]['DataLancto'],
                        "CHAVE_REF2"       => $array[0]['Operadora'].'/'.$forma
                    ],
                    "ITEM_CLIENTE"=> [
                        "TRANSACAO"         => $array[0]['NroLancamento'],
                        "COD_CLIENTE"      => '1',//criar campo
                        //"COD_CLIENTE"      => $array[0][''],//criar campo
                        "ATRIBUICAO"       => $array[0]['PedidoID'],
                        "MONTANTE"         => $array[0]['Valor'],
                        "VENCTO"           => $array[0]['DataLancto'],
                        "CHAVE_REF1"       => $array[0]['TNroCV'],
                        "CHAVE_REF2"       => $array[0]['TID'],
                        "CHAVE_REF3"       => $array[0]['FormaID']."+".$array[0]['Origem'],
                        "CENTRO_LUCRO"     => $array[0]['FilialID'],
                        "DIVISAO"          => 7000,
                        "REF_PAGTO"        => $array[0]['NroParcelas'],
                        "TEXTO"            => $array[0]['Estabelecimento'],
                        "ZLSCH"            => $array[0]['FormaID']
                    ],
                    "ITEM_CARTAO"=> [
                        "TRANSACAO"         => $array[0]['NroLancamento'],
                        "COD_CLIENTE"      => $array[0]['UsuarioID'],
                        "ATRIBUICAO"       => $array[0]['PedidoID'],
                        "MONTANTE"         => $array[0]['Valor'],
                        "VENCTO"           => $array[0]['DataLancto'],
                        "CHAVE_REF1"       => $array[0]['TNroCV'],
                        "CHAVE_REF2"       => $array[0]['TID'],
                        "CHAVE_REF3"       => $array[0]['FormaID'].'+'.$array[0]['Origem'],
                        "CENTRO_LUCRO"     => $array[0]['FilialID'],
                        "DIVISAO"          => 7000,
                        "REF_PAGTO"        => $array[0]['NroParcelas'],
                        "TEXTO"            => $array[0]['Estabelecimento'],
                        "ZLSCH"            => $array[0]['FormaID']
                    ]
                ]
            ];
        }
        return $data;
    }
}