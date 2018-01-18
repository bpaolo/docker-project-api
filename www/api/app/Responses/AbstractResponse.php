<?php

namespace App\Responses;

abstract class AbstractResponse
{
    /**
     * Http Code.
     *
     * @var integer
     */
    public $code; 
    /**
     * Erros da Aplicação.
     *
     * @var array
     */
    public $errors; 
    /**
     * Retorno de Dados.
     *
     * @var array
     */
    public $data;  
    /**
     * Variável de Retorno
     *
     * @return array
     */
    public $response;
    /**
     * HTTP Message
     *
     * @return array
     */
    public $http_message; 
    /**
     * Função Abstrata de Response
     *
     * @return array
     */
    abstract protected function response($code=null, $errors=null, $data=null);
    /**
     * Função Pública de Resposta
     *
     * @return array
     */
    public function setResponse($code, $errors, $data) {
        $this->code     = $code;
        $this->errors   = $errors;
        $this->data     = $data;
        return $this->response($code, $errors, $data);
    }
}