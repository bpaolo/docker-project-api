<?php

namespace App\Requests\Rac;

//UUID Generator
use Ramsey\Uuid\Uuid;

class EncerramentoDeContratoRule 
{
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $interfaceID = 'I012';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'EncerramentoContrato_I013';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [ 
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
    public static function parse($array=null) {
        $data = '';
        if ($array) {
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();

            $data = [
                'GUID'           => $guid,
                'COD_INTERF'     => $interfaceID,
                'VBELN'          => $array['VBELN'],
                'ZZTPCLIENTE'    => $array['ZZTPCLIENTE'],
                'ZZUPGRADE'      => $array['ZZUPGRADE'],
                'ZZNRCONTRATO'   => $array['ZZNRCONTRATO'],
                'ZZNRPERIODO'    => $array['ZZNRPERIODO'],
                'ZZNRADITIVO'    => $array['ZZNRADITIVO'],
                'ZZNRRESERVA'    => $array['ZZNRRESERVA'],
                'ZZTPCANAL'      => $array['ZZTPCANAL'],
                'ZZCODREF'       => $array['ZZCODREF'],
                'ZZDTARES'       => $array['ZZDTARES'],
                'ZZHRARES'       => $array['ZZHRARES'],
                'ZZLJRET'        => $array['ZZLJRET'],
                'ZZDTARET'       => $array['ZZDTARET'],
                'ZZHRARET'       => $array['ZZHRARET'],
                'ZZPLACARET'     => $array['ZZPLACARET'],
                'ZZGPRET'        => $array['ZZGPRET'],
                'ZZLJDEV'        => $array['ZZLJDEV'],
                'ZZDTADEV'       => $array['ZZDTADEV'],
                'ZZHRADEV'       => $array['ZZHRADEV'],
                'ZZPLACADEV'     => $array['ZZPLACADEV'],
                'ZZGPDEV'        => $array['ZZGPDEV'],
                'ZZVLTOTAL_PED'  => $array['ZZVLTOTAL_PED'],
                'ZZDTAPGTO'      => $array['ZZDTAPGTO'],
                'ZZDTAENC'       => $array['ZZDTAENC'],
                'ZZDURLOC'       => $array['ZZDURLOC'],
                'ZZDTAINI'       => $array['ZZDTAINI'],
                'ZZDTAFIM'       => $array['ZZDTAFIM'],
                'ZZVLTOTAL'      => $array['ZZVLTOTAL'],
                'AUGRU'              => $array['AUGRU'],
                'ZZDENTREG'          => $array['ZZDENTREG'],
                'WAERK'              => $array['WAERK'],
                'ZTEXT_FORMAPGTO'    => $array['ZTEXT_FORMAPGTO'],
                'ZTEXT_INFO_COMPLEM' => $array['ZTEXT_INFO_COMPLEM']
            ];

            $dataJson = '{';
            $i=1;
            foreach ($data as $key => $value){
                $dataJson .= " \"{$key}\": \"{$value}\" ";
                if($i<count($data)){
                    $dataJson .= ',';
                }
                $i++;
            }
            $dataJson .= (isset($array['ITENS']) && $array['ITENS'] != '') ? ", {$array['ITENS']}" : '';
            $dataJson .= (isset($array['PARCEIROS']) && $array['PARCEIROS'] != '') ? ", {$array['PARCEIROS']}" : '';
            $dataJson .= (isset($array['DADOS_PGTO']) && $array['DADOS_PGTO'] != '') ? ", {$array['DADOS_PGTO']}" : '';
            $dataJson .= "}";
        }
        return $dataJson;
    }
}