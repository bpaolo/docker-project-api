<?php

namespace App\Publishers;
// Abstracts
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\AtualizaCaixaRule;
// Consumers
use App\Consumers\AtualizaCaixaConsumer;

class AtualizaCaixaPublisher extends AbstractPublisher
{
	/**
     * Função que envia para o consumer
     *
     * @return array
     */
    public function fetch(array $array = null) {

        $updatePay  = new AtualizaCaixaConsumer();
        $rule       = new AtualizaCaixaRule();

        return  $updatePay->handle($rule->parse($array));
    }
}