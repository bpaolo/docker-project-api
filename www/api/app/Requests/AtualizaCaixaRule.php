<?php

namespace App\Requests;

use Validator;

class AtualizaCaixaRule 
{
    /* 
     * ID Usado na Interface de Envio
     */
    public static $interfaceID = '';
    /* 
     * Endpoint Usado na Interface de Envio
     */
    public static $endpoint = '';
    /* 
     * Regras de Validação REST
     */
    public static $rules = [
        'LctoAID'           => '',
        'LctoID'            => '',
        'DtIntegracao'      => '',
        'StatusIntegracao'  => '',
        'IntegracaoID'      => '',
        'CodigoSAP'         => ''
    ];
    /**
     * Conversão de Dados do Payload para formato da Interface
     *
     * @param  int $array['LctoID']
     * @param  \DateTime|int  $array['DtIntegracao']
     * @param  string  $array['StatusIntegracao']
     * @param  string  $array['IntegracaoID']
     * @param  string  $array['CodigoSAP']
     * @return array
     */
    public static function parse($array) {
        $data = [];
        if ($array) {

            /*$data = [

                'GUID'=> $array['GUID'],
                'DATA'=> $array['DATA'],
                'HORA'=> $array['HORA'],
                'LISTA_PGTO'=>
                    [
                        'NroFaturamentoSAP'=> $array['DOC_FATURAMENTO'],
                        'ContratoNro'=> $array['CONTRATO'],
                        'FaturaID'=> $array['FATURA'],
                        'D_FilialID'=> $array['FILIAL'],
                        'ClienteID'=> $array['CLIENTE'],
                        'DataEmissao'=> $array['DT_EMISSAO'],
                        'FormaID'=> $array['COND_PGTO'],
                        'Vencimento'=> $array['VENCIMENTO'],
                        'Pagamento'=> $array['DT_PGTO'],
                        'Valor'=> $array['VALOR'],
                        'CONTA_PGTO'=> $array['CONTA_PGTO'],
                        'FORMA_PGTO'=> $array['FORMA_PGTO']
                    ]
            ];*/
            $data = [

            'LctoAID'           => $array['LctoAID'],
            'LctoID'            => $array['LctoID'],
            'DtIntegracao'      => $array['DtIntegracao'],
            'StatusIntegracao'  => $array['StatusIntegracao'],
            'IntegracaoID'      => $array['IntegracaoID'],
            'CodigoSAP'         => $array['CodigoSAP']

            ];
        }
        return $data;
    }
}