<?php

namespace App\Publishers\Rac;
// Abstracts 
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Rac\EncerramentoDeContratoRule;
// Interfaces
use App\Interfaces\RabbitClientInterface;
// Models
use App\Models\ModelEncerrarContratos;

class EncerramentoDeContratoPublisher extends AbstractPublisher
{
	/**
     * Função que envia para o SAP
     *
     * @return array
     */
    public function fetch(array $payload = null) {
        // Filtros para Query do Banco
        $dataAtual           = '2017-02-25';
        $filter['StatusID']  = '3';
        $filter['Sequencia'] = '100';
        $filter['DataFinal'] = $dataAtual;
        $filter['limit']     = 4;
        // Recupera dados de Encerramento do Contrato do Banco
        $data = ModelEncerrarContratos::Contratos($filter);
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
            $array[] = EncerramentoDeContratoRule::parse($data[$cont]);
            //dd($array);
            $cont++;
        }
        if($array) {
            // Envia para Interface 
            $integrate = $interface->send($array, 'SendSapEncerramentoContrato_I013');
            return $integrate;
        }
        return false;
    }
}