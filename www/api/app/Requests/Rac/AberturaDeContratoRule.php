<?php

namespace App\Requests\Rac;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class AberturaDeContratoRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I012';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'DadosContrato_I012';
     /* 
     * Regras de Validação REST
     */
    public static $rules =  [
        'TIPO_ORDEM'              => '',
        'EMISSOR'                 => '',
        'KUNNR_EMISSOR'           => '',
        'PAGADOR'                 => '',
        'KUNNR_PAGADOR'           => '',
        'AGENCIA'                 => '',
        'KUNNR_AGENCIA'           => '',
        'AG_TRIPARTITE'           => '',
        'KUNNR_AG_TRIPARTITE'     => '',
        'COND_ADICIONAL'          => '',
        'KUNNR_COND_ADICIONAL'    => '',
        'AG_ABERTURA'             => '',
        'PERNR_AG_ABERTURA'       => '',
        'AG_ENCERRAMENTO'         => '',
        'PERNR_AG_ENCERRAMENTO'   => '',
        'ZZUPGRADE'               => '',
        'ZZNRCONTRATO'            => '',
        'ZZNRPERIODO'             => '',
        'ZZNRADITIVO'             => '',
        'ZZNRRESERVA'             => '',
        'ZZTPCANAL'               => '',
        'ZZCODREF'                => '',
        'ZZDTARES'                => '',
        'ZZHRARES'                => '',
        'ZZLJRET'                 => '',
        'ZZDTARET'                => '',
        'ZZHRARET'                => '',
        'ZZPLACARET'              => '',
        'ZZGPRET'                 => '',
        'ZZLJDEV'                 => '',
        'ZZDTADEV'                => '',
        'ZZHRADEV'                => '',
        'ZZPLACADEV'              => '',
        'ZZGPDEV'                 => '',
        'ZZVLTOTAL_PED'           => '',
        'ZZDTAPGTO'               => '',
        'ZZDTAENC'                => '',
        'ZZDURLOC'                => '',
        'ZZDTAINI'                => '',
        'ZZDTAFIM'                => '',
        'ZZVLTOTAL'               => '',
        'WAERK'                   => '',
        'MATNR'                   => '',
        'KWMENG'                  => '',
        'WERKS'                   => '',
        'COND_VALUE1'             => '',
        'COND_VALUE2'             => '',
        'COND_VALUE3'             => '',
        'COND_VALUE4'             => '',
        'PRCTR'                   => '',
        'KUNNR'                   => '',
        'ZLSCH'                   => '',
        'COND_VALUE5'             => '',
        'ZZTRANSACAO'             => '',
        'ZTEXT_FORMAPGTO'         => '',
        'ZTEXT_INFO_COMPLEM'      => ''
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($obj=null) {

        $data = array();
        if ($obj) {

            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $data['GUID']           = $guid;
            $data['COD_INTERF']     = $interfaceID;
            $data['TIPO_ORDEM']     = $obj->TIPO_ORDEM;
            $data['ZZTPCLIENTE']    = $obj->ZZTPCLIENTE;
            $data['ZZUPGRADE']      = $obj->ZZUPGRADE;
            $data['ZZNRCONTRATO']   = $obj->ZZNRCONTRATO;
            $data['ZZNRPERIODO']    = $obj->ZZNRPERIODO;
            $data['ZZNRADITIVO']    = $obj->ZZNRADITIVO;
            $data['ZZNRRESERVA']    = $obj->ZZNRRESERVA;
            $data['ZZTPCANAL']      = $obj->ZZTPCANAL;
            $data['ZZCODREF']       = $obj->ZZCODREF;
            $data['ZZDTARES']       = $obj->ZZDTARES;
            $data['ZZHRARES']       = $obj->ZZHRARES;
            $data['ZZLJRET']        = $obj->ZZLJRET;
            $data['ZZDTARET']       = $obj->ZZDTARET;
            $data['ZZHRARET']       = $obj->ZZHRARET;
            $data['ZZPLACARET']     = $obj->ZZPLACARET;
            $data['ZZGPRET']        = $obj->ZZGPRET;
            $data['ZZLJDEV']        = $obj->ZZLJDEV;
            $data['ZZDTADEV']       = $obj->ZZDTADEV;
            $data['ZZHRADEV']       = $obj->ZZHRADEV;
            $data['ZZPLACADEV']     = $obj->ZZPLACADEV;
            $data['ZZGPDEV']        = $obj->ZZGPDEV;
            $data['ZZVLTOTAL_PED']  = $obj->ZZVLTOTAL_PED;
            $data['ZZDTAPGTO']      = $obj->ZZDTAPGTO;
            $data['ZZDTAENC']       = $obj->ZZDTAENC;
            $data['ZZDURLOC']       = $obj->ZZDURLOC;
            $data['ZZDTAINI']       = $obj->ZZDTAINI;
            $data['ZZDTAFIM']       = $obj->ZZDTAFIM;
            $data['ZZVLTOTAL']      = $obj->ZZVLTOTAL;
            $data['WAERK']          = $obj->WAERK;
            $data['PMNTTRMS']           = $obj->PMNTTRMS;
            $data['ZTEXT_FORMAPGTO']    = $obj->ZTEXT_FORMAPGTO;
            $data['ZTEXT_INFO_COMPLEM'] = $obj->ZTEXT_INFO_COMPLEM;

            $dataJson = '{';
            foreach ($data as $key => $value){
                $dataJson .= '"'.$key.'": "'.$value .'",';
            }
            if(isset($obj->PRO) && $obj->PRO !=''){
                $dataJson .= $obj->PRO;
            };
            if(isset($obj->PAR) && $obj->PAR !=''){
                $dataJson .= ','.$obj->PAR;
            };
            if(isset($obj->LANC) && $obj->PRO !=''){
                $dataJson .= ','.$obj->LANC;
            };
            $dataJson .= '}';
        }
        return $dataJson;
    }
}