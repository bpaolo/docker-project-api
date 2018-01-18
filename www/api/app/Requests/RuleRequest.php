<?php

namespace App\Requests;

use Validator;

class RuleRequest
{
    /**
     * Verifica se a Regra é Válida / Campos Requeridos
     *
     * @param  $request
     * @param  $regra
     *
     * @return boolean
     */
    public static function isValid($request, $regra) {

        $validator = Validator::make($request, $regra);

        if(count($validator->errors())) {
            $retorno = $validator->errors();
            return $retorno;
        }
        return false;
    }
}