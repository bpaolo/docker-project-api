<?php

namespace App\Consumers\Corporativo\Sic;

// Abstracts
use App\Consumers\AbstractConsumer;
// Rules
use App\Requests\Corporativo\Sic\SicFornecedorDocumentoRule;
// Clients
use App\Interfaces\SicClientInterface;

class BuscaFornecedorDocumentoConsumer extends AbstractConsumer
{ 
	protected function consume($payload) {
		// Instancia Interface do Sic Client
        $interface = new SicClientInterface();
        // Recebe o Payload do Publisher e Envia ao Sic
		$integrate = $interface->send($payload, SicFornecedorDocumentoRule::$endpoint);
		// Retorno do Sic 
		if(isset($integrate->ObterCadastroSICResult->Retorno)) {
			$integrate 	= $integrate->ObterCadastroSICResult->Retorno->DadosCadastraisDtc;
			return json_encode($integrate);
		}
		if($integrate) {
			return 'NoContent';
		}
		// Retorno em caso de Erro
		return false;
	}

}
