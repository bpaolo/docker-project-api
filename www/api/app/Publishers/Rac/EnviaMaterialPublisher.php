<?php

namespace App\Publishers\Rac;
// Abstracts
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Rac\EnviaMaterialRule;
// Consumers
use App\Consumers\Rac\EnviaMaterialConsumer;

class EnviaMaterialPublisher extends AbstractPublisher
{
	/**
     * Função que envia para o consumer
     *
     * @return array
     */
    public function fetch(array $array = null) {

        $updatePay  = new EnviaMaterialConsumer();
        $rule       = new EnviaMaterialRule();

        return  $updatePay->handle($rule->parse($array));
    }
}