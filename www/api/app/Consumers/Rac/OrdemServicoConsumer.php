<?php

namespace App\Consumers\Rac;

// Abstract
use App\Consumers\AbstractConsumer;
// Interfaces
use App\Interfaces\RabbitClientInterface;
// Rules
use App\Requests\Rac\OrdemServicoRule;

class OrdemServicoConsumer extends AbstractConsumer
{
    protected function consume($payload) {

        // Instancia Interface do Rabbit MQ
        $interface = new RabbitClientInterface();
        // Recebe o Payload de uma fila do RabbitMQ e Envia ao SAP
		$integrate = $interface->receive('SendSapDadosOrdemServico_I014', OrdemServicoRule::$endpoint);
		return $integrate;
    }
}
