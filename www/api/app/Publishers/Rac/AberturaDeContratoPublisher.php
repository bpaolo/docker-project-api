<?php

namespace App\Publishers\Rac;
// Abstracts 
use App\Publishers\AbstractPublisher;
// Rules
use App\Requests\Rac\AberturaDeContratoRule;
// Interfaces
use App\Interfaces\RabbitClientInterface;
// Models
use App\Models\ModelAberturaContratos;

class AberturaDeContratoPublisher extends AbstractPublisher
{
    /**
     * Função que envia para o SAP
     *
     * @return array
     */
    public function fetch(array $payload = null) {
        // Filtros para Query do Banco
        $filter['dataAtual']    = '2017-02-25'; // date('Y-m-d');;
        $filter['Sequencia']    = 100;
        $filter['StatusID']     = 1;
        // Recupera dados de Encerramento do Contrato do Banco
        $data = ModelAberturaContratos::C009_Contratos($filter);
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
            $array[] = AberturaDeContratoRule::parse($data[$cont]);
            //dd($array);
            $cont++;
        }
        if($array) {
            // Envia para Interface 
            $integrate = $interface->send($array, 'SendSapDadosContrato_I012');
            return $integrate;
        }
        return false;
    }
}