<?php

namespace App\Publishers;
// Abstracts 
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\AtualizaPagamentoRule;
// Consumer
use App\Consumers\AtualizaPagamentoConsumer;

class AtualizaPagamentoPublisher extends AbstractPublisher
{
	/**
     * Função que envia para o consumer
     *
     * @return array
     */
    private function fetch(array $array = null){

        $updatePay  = new AtualizaPagamentoConsumer();
        $rule       = new AtualizaPagamentoRule();

        return  $updatePay->handle($rule->parse($array));
    }
}