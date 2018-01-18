<?php

namespace App\Consumers;

// Abstracts
use App\Consumers\AbstractConsumer;
// Models
use App\Models\ModelAtualizaCaixa;

class AtualizaCaixaConsumer extends AbstractConsumer
{
	protected function consume($payload) {

        $model   = new ModelAtualizaCaixa();
        return $model->updatePay($payload);
		
	}
}