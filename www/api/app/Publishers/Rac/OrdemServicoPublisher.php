<?php

namespace App\Publishers\Rac;

// Abstracts 
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Rac\OrdemServicoRule;
// Interfaces
use App\Interfaces\RabbitClientInterface;
// Models
use App\Models\ModelOrdemServico;

class OrdemServicoPublisher extends AbstractPublisher
{
    /**
     * Função que envia para o rabbitMQ
     *
     * @return array
     */
    public function fetch(array $payload = null) {
        // Filtros para Query do Banco
        /*$filter['dataAtual']    =*/

        // Recupera dados de ordem de serviços do Banco
        $data = ModelOrdemServico::OrderService();

        // Valida retorno do Banco
        if(count($data) == 0) {
            return false;
        }

        // Instancia Rabbit Client
        $interface = new RabbitClientInterface();
        // Variáveis de Controle e Retorno
        $cont  = 0;
        $array = [];


        // Loop de Conversão dos Dados e Envio para o SAP
        foreach ($data as $v) {
            // Faz o Parse de Dados
            $array[] = OrdemServicoRule::parse($data[$cont]);
            //dd($array);
            $cont++;
        }
        #dd($array);
        if($array) {
            // Envia para Interface

            $integrate = $interface->send($array, 'SendSapDadosOrdemServico_I014');
            return $integrate;
        }
        return false;
    }

}