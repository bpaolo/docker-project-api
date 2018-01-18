<?php

namespace App\Requests\Rac;

use Validator;

class EnviaMaterialRule
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
                            'Descricao'  => '',
                            'Ativo'      => '',
                            'PMO'        => '',
                            'CodigoSAP'  => ''
                           ];
    /**
     * Conversão de Dados do Payload para formato da Interface
     *
     * @param  string  $array['Descricao']
     * @param  string  $array['PMO']
     * @return array
     */
    public static function parse($array) {
        $data = [];
        if ($array) {

            $data = [

            'Descricao'     => $array['Descricao'],
            'Ativo'         => 2,
            'PMO'           => $array['PMO'],
            'CodigoSAP'     => $array['CodigoSAP']

            ];
        }
        return $data;
    }
}