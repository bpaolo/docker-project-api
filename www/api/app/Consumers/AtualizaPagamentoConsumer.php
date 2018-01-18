<?php

namespace App\Consumers;

// Abstracts
use App\Consumers\AbstractConsumer;
//Models
use App\Models\ModelAtualizaPagamento;

class AtualizaPagamentoConsumer extends AbstractConsumer
{
    protected function consume($payload) {

        $model   = new ModelAtualizaPagamento();
        return $model->updatePay($payload);

    }
}