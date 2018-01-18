<?php

namespace App\Publishers\Corporativo\Sic;
// Abstracts
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Corporativo\Sic\SicClienteRule;
// Consumers
use App\Consumers\Corporativo\Sic\BuscaClienteConsumer;

class BuscaClientePublisher extends AbstractPublisher
{
    /**
     * Função que envia para o consumer
     *
     * @return array
     */
    public function fetch(array $payload = null) {
        // Converte os dados para formato json SAP
        $data_parsed = SicClienteRule::parse($payload);
        // Instancia Consumer
        $consumer    = new BuscaClienteConsumer(); 
        // Envia para o Consumer os dados do Payload convertido
        $integrate   = $consumer->handle($data_parsed);
        return $integrate;
    }
}