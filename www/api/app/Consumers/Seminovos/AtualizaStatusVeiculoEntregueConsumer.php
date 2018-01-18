<?php

namespace App\Consumers\Seminovos;

// Abstracts
use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\Seminovos\AtualizaStatusVeiculoEntregueRule;

class AtualizaStatusVeiculoEntregueConsumer extends AbstractConsumer
{
    protected function consume($payload) {
    	// Instancia Interface do Sap Client
        $interface = new SapClientInterface();
        // Recebe o Payload do Publisher e Envia ao SAP
		$integrate = $interface->send($payload, AtualizaStatusVeiculoEntregueRule::$endpoint);
		return $integrate;
    }
}