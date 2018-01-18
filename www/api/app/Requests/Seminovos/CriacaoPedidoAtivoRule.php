<?php

namespace App\Requests\Seminovos;

//UUID Generator
use Ramsey\Uuid\Uuid;

class CriacaoPedidoAtivoRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I022';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'CriacaoPedidoAtivo_I022';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [
        'tipo_ordem'                => 'required|string',
        'vbeln'                     => 'string',
        'kunnr_emissor'             => 'required|string',
        'kunnr_pagador'             => 'required|string',
        'kunnr_boleto'              => 'string',     
        'pern'                      => 'required|string',
        'erdat'                     => 'required|string',
        'plant'                     => 'required|string', 
        'purch_no_c'                => 'required|string',
        'zterm'                     => 'required|string',
        'waerk'                     => 'required|string', 
        'matnr'                     => 'required|string',
        'kbmeng'                    => 'required|string',
        'zznpedvetor'               => 'required|string',
        'zznlotevetor'              => 'string',
        'zztplote'                  => 'string',
        'zztiplote_subtipo'         => 'string',
        'cond_value'                => 'required|string',
        'cond_value2'               => 'required|string',
        'cond_value3'               => 'required|string',
        'zzanln1'                   => 'required|string',
        'mvgr1'                     => 'required|string',
        'mvgr2'                     => 'required|string',
        'ztext_formapgto'           => 'string',
        'ztext_info_complem'        => 'string',
        'ztext_observacao'          => 'string',
        'prctr'                     => 'required|string',
        'dados_pgto'                => 'required|string'
    ];
    
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($array) {
        if ($array) {
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();
            
            $pedido_ativo['COD_INTERF']         = 'I022';
            $pedido_ativo['TIPO_ORDEM']         = $array['tipo_ordem'];
            $pedido_ativo['VBELN']              = $array['vbeln'];
            $pedido_ativo['KUNNR_EMISSOR']      = $array['kunnr_emissor'];
            $pedido_ativo['KUNNR_PAGADOR']      = $array['kunnr_pagador'];
            $pedido_ativo['KUNNR_BOLETO']       = $array['kunnr_boleto'];
            $pedido_ativo['PERN']               = $array['pern'];
            $pedido_ativo['ERDAT']              = $array['erdat'];
            $pedido_ativo['PLANT']              = $array['plant'];
            $pedido_ativo['PURCH_NO_C']         = $array['purch_no_c'];
            $pedido_ativo['ZTERM']              = $array['zterm'];
            $pedido_ativo['WAERK']              = $array['waerk'];
            $pedido_ativo['MATNR']              = $array['matnr'];
            $pedido_ativo['KBMENG']             = $array['kbmeng'];
            $pedido_ativo['ZZNPEDVETOR']        = $array['zznpedvetor'];
            $pedido_ativo['ZZNLOTEVETOR']       = $array['zznlotevetor'];
            $pedido_ativo['ZZTPLOTE']           = $array['zztplote'];
            $pedido_ativo['ZZTIPLOTE_SUBTIPO']  = $array['zztiplote_subtipo'];
            $pedido_ativo['COND_VALUE']         = $array['cond_value'];
            $pedido_ativo['COND_VALUE2']        = $array['cond_value2'];
            $pedido_ativo['COND_VALUE3']        = $array['cond_value3'];
            $pedido_ativo['ZZANLN1']            = $array['zzanln1'];
            $pedido_ativo['MVGR1']              = $array['mvgr1'];
            $pedido_ativo['MVGR2']              = $array['mvgr2'];
            $pedido_ativo['ZTEXT_FORMAPGTO']    = $array['ztext_formapgto'];
            $pedido_ativo['ZTEXT_INFO_COMPLEM'] = $array['ztext_info_complem'];
            $pedido_ativo['ZTEXT_OBSERVACAO']   = $array['ztext_observacao'];
            $pedido_ativo['PRCTR']              = $array['prctr'];
            
            $dataJson = '{';
            $dataJson .= '"GUID"'.' : "'.$guid.'",';
            $dataJson .= '"PEDIDO_ATIVO"'.' : {';
            $max    = count($pedido_ativo);
            $cont   = 1; 
            foreach ($pedido_ativo as $key => $value) {
                $dataJson .= '"'.$key.'": "'.$value .'"';
                if($cont < $max || isset($array['dados_pgto'])) {
                    $dataJson .= ",";
                }
                $cont++;
            }
            $dataJson .= $array['dados_pgto'];  
            $dataJson .= '}';
            $dataJson .= '}';

            return $dataJson;
        }
        return false;
    }
}