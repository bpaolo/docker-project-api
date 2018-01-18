<?php

namespace App\Requests\Seminovos;

use Validator;

//UUID Generator
use Ramsey\Uuid\Uuid;

class AtualizaStatusFinanceiroRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = 'I009';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = 'AtualizaStFinalizado_I009';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [
        'vbeln'     => 'required',
        'mvgr1'     => 'required',
        'doc_fat'   => 'required' 
    ];
    /* 
     * Conversão de Dados do Payload para formato da Interface
     */
    public static function parse($array) {
        
        if ($array) {
            // Generate GUID
            $uuid1  = Uuid::uuid1();
            $guid   = $uuid1->toString();
            // Recupera as Variáveis
            $atualiza['VBELN']    = $array['vbeln'];
            $atualiza['MVGR1']    = $array['mvgr1'];
            $atualiza['DOC_FAT']  = $array['doc_fat'];
            // Monta o Json
            $dataJson = '{';
            $dataJson .= '"GUID"'.' : "'.$guid.'",';
            $dataJson .= '"ORDEM_VENDA"'.' : {';
            $max    = count($atualiza);
            $cont   = 1; 
            foreach ($atualiza as $key => $value) {
                $dataJson .= '"'.$key.'": "'.$value .'"';
                if($cont < $max) {
                    $dataJson .= ",";
                }
                $cont++;
            }
            $dataJson .= '}';
            $dataJson .= '}';

            return $dataJson;
        }
        return false;
    }
}