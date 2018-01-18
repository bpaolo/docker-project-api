<?php

namespace App\Publishers\Seminovos;
// Abstracts 
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Seminovos\CriacaoPedidoAtivoRule;
// Interfaces
use App\Interfaces\SapClientInterface;
// Models
use App\Models\ModelEncerrarContratos;
// Consumer
use App\Consumers\Seminovos\CriacaoPedidoAtivoConsumer;

class CriacaoPedidoAtivoPublisher extends AbstractPublisher
{
    /**
     * Função que recupera dados do payload e converte para consumer
     *
     * @return array
     */
    protected function fetch(array $payload = null) {
        // Converte os dados para formato json SAP
        $data_parsed = CriacaoPedidoAtivoRule::parse($payload);
        // Instancia Consumer
        $consumer    = new CriacaoPedidoAtivoConsumer();
        // Envia para o Consumer os dados do Payload convertido
        $integrate   = $consumer->handle($data_parsed);
        return $integrate;
    }
}