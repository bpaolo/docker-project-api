<?php

namespace App\Interfaces;

use SoapClient;
use SOAPHeader;

class SicClientInterface
{
    /**
     * Dados de Conexão do SIC
     */
    protected $connection = [];
    /**
     * Método Construtor
     */
    public function __construct() {
        $this->connection = [
            'host'      => env('SIC_HOST' , 'http://sbqa.jsl.com.br:8082/Servicos/'),
            'user'      => env('SIC_LOGIN', 'VETOR_APP'),
            'password'  => env('SIC_PASSWORD', 'VToRapp'),
        ];
    }
    /**
     * Envio de Envio do Payload para o Sic.
     *
     * @param  $data, $endpoint
     *
     * @return $response
     */
    public function send($data, $endpoint) {
        // Metodo de Ação na API
        $method = $data['method'];
        // Parametros de Acesso
        $params = array(
            'login' => $this->connection['user'],
            'senha' => $this->connection['password']
        );
        //Auth SIC
        $endpointAuth   = $this->connection['host'].'Seguranca/SegurancaSVC.svc?wsdl';
        $client         = new SoapClient($endpointAuth);
        $response       = $client->__soapCall("LogInAplicacao", array($params));
        $token          = $response->LogInAplicacaoResult->Retorno->CodigoAcesso;

        if($token){
            //Endpoint de Consumo SIC
            $endpoint = $this->connection['host'].$endpoint;
            $auth     = (object) array('TokenAplicacao' => $token);
            $client   = new SoapClient($endpoint);
            $params   = [
                'trace'              => 1,
                'connection_timeout' => 120,
                'soap_version'       => SOAP_1_2,
                'empresa'            => $data['id_empresa'],
                'tipoCadastro'       => $data['tipo_cadastro'],
                'tipoPessoa'         => $data['tipo_pessoa']??'',
                'numeroDocumento'    => $data['documento']??'' 
            ];
            
            $header   = new SOAPHeader('Jsl_Header', 'JSLHeader', $auth, false);
            $client->__setSoapHeaders($header);
            $response = $client->__soapCall($method, array($params));
            
            return $response;
        }
        return false;
    }
}