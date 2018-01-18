<?php

namespace App\Publishers;

use App\Publishers\Contracts\HasPayload;

abstract class AbstractPublisher implements HasPayload
{
    /**
     * Params de request.
     *
     * @var array
     */
    public $requestParams;  
    /**
     * Function Fetch Params
     *
     * @return array
     */
    abstract protected function fetch(array $array = null);
    /**
     * Função que retorna o payload
     *
     * @return array
     */
    public function getPayload(array $requestParams=null) {
        $this->requestParams = $requestParams;
        return $this->fetch($requestParams);
    }

}