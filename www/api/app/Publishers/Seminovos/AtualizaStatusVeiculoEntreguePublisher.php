<?php

namespace App\Publishers\Seminovos;
// Abstracts 
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Seminovos\AtualizaStatusVeiculoEntregueRule;
// Interfaces
use App\Interfaces\SapClientInterface;
// Models
use App\Models\ModelEncerrarContratos;
// Consumer
use App\Consumers\Seminovos\AtualizaStatusVeiculoEntregueConsumer;

class AtualizaStatusVeiculoEntreguePublisher extends AbstractPublisher
{
    /**
     * Função que recupera dados do payload e converte para consumer
     *
     * @return array
     */
    protected function fetch(array $payload = null) {
        // Converte os dados para formato json SAP
        $data_parsed = AtualizaStatusVeiculoEntregueRule::parse($payload);
        // Encode para Json
        $data_parsed = json_encode($data_parsed);
        // Instancia Consumer
        $consumer    = new AtualizaStatusVeiculoEntregueConsumer(); 
        // Envia para o Consumer os dados do Payload convertido
        $integrate   = $consumer->handle($data_parsed);
        return $integrate;
    }
}