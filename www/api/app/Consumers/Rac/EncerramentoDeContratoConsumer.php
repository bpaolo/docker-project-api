<?php

namespace App\Consumers\Rac;

// Abstract
use App\Consumers\AbstractConsumer;
// Interfaces
use App\Interfaces\RabbitClientInterface;
// Rules
use App\Requests\Rac\EncerramentoDeContratoRule;

class EncerramentoDeContratoConsumer extends AbstractConsumer
{
    protected function consume($payload) {
    	// Instancia Interface do Rabbit MQ
        $interface = new RabbitClientInterface();
        // Recebe o Payload de uma fila do RabbitMQ e Envia ao SAP
		$integrate = $interface->receive('SendSapEncerramentoContrato_I013', EncerramentoDeContratoRule::$endpoint);
		return $integrate;
    }
}
