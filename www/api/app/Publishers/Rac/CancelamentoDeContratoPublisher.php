<?php

namespace App\Publishers\Rac;
// Abstracts
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Rac\CancelamentoDeContratoRule;
// Consumers
use App\Consumers\Rac\CancelamentoDeContratoConsumer;

class CancelamentoDeContratoPublisher extends AbstractPublisher
{
	/**
     * Função que envia para o consumer
     *
     * @return array
     */
    public function fetch(array $payload = null) {
        // Converte os dados para formato json SAP
        $data_parsed = CancelamentoDeContratoRule::parse($payload);
        // Converte para Json
        $data_parsed = json_encode($data_parsed);
        // Instancia Consumer
        $consumer    = new CancelamentoDeContratoConsumer();
        // Envia para o Consumer os dados do Payload convertido
        $integrate   = $consumer->handle($data_parsed);
        return $integrate;
    }
}