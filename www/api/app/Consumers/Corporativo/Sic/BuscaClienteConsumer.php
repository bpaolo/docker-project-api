<?php

namespace App\Consumers\Corporativo\Sic;
// Abstracts
use App\Consumers\AbstractConsumer;
// Rules
use App\Requests\Corporativo\Sic\SicClienteRule;
// Clients
use App\Interfaces\SicClientInterface;

class BuscaClienteConsumer extends AbstractConsumer
{  
	protected function consume($payload) {
		// Instancia Interface do Sic Client
        $interface = new SicClientInterface();
        // Recebe o Payload do Publisher e Envia ao Sic
		$integrate = $interface->send($payload, SicClienteRule::$endpoint);
		// Retorno do Sic 
		if(isset($integrate->ObterListaCadastrosSICResult->Retorno)) {
			$integrate 	= $integrate->ObterListaCadastrosSICResult->Retorno->DadosCadastroIntegracaoDTC;
			return json_encode($integrate);
		}
		if($integrate) {
			return 'NoContent';
		}
		// Retorno em caso de Erro
		return false;
	}
}
