<?php 

namespace App\Publishers\Contracts;

interface HasPayload
{
    public function getPayload(array $requestParams=null);
}