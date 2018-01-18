<?php

namespace App\Consumers\Rac;

// Abstracts
use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\Rac\CancelamentoDeContratoRule;

class CancelamentoDeContratoConsumer extends AbstractConsumer
{
    protected function consume($payload) {
		// Instancia Interface do Sap Client
        $interface = new SapClientInterface();
        // Recebe o Payload do Publisher e Envia ao SAP
		$integrate = $interface->send($payload, CancelamentoDeContratoRule::$endpoint);
		return $integrate;
    }
}