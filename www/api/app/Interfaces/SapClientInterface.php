<?php

namespace App\Interfaces;

use GuzzleHttp;
//Models
use App\Models\ModelLogs;

class SapClientInterface
{
    /**
     * Dados de Conexão do SAP
     */
    protected $connection = [];
    /**
     * Método Construtor
     */
    public function __construct() {
        $this->connection = [
            'host'      => env('SAP_HOST', 'http://10.141.2.30:58500/RESTAdapter/'),
            'user'      => env('SAP_LOGIN', 'PI-VETOR'),
            'password'  => env('SAP_PASSWORD', '@Jsl1720'),
        ];
    }
    /**
     * Envio de Payload para o SAP.
     *
     * @param  $data, $endpoint
     *
     * @return boolean
     */
    public function send($data, $endpoint) {
        //dd($data);
        // Instancia Client do Guzzle
        $client = new GuzzleHttp\Client();
        $data   = str_replace("\r", '', $data);
        $data   = str_replace("\n", '', $data);
       
        if(is_object(json_decode($data))) {
            // Decode do Data 
            $json = json_decode($data);
            // Recupera o Guid para Log
            $guid  = $json->GUID;
        } 
        // Instancia Model de Log
        $logs = new ModelLogs;
        // Recupera o Log pelo Guid se existir na base
        $logId = null;
        if($guid) {
            $logId = $logs->getLog($guid);
        }
        // Função que envia Json para SAP
        try {
            $res = $client->post(
                $this->connection['host'].$endpoint, 
                [
                    'content-type'  => 'application/json',
                    'auth'          => [$this->connection['user'], $this->connection['password']],
                    'body'          => $data
                ]
            );
        } catch (\Exception $e) {
            $status = 6;
            $resposta = '500 - Erro Inexperado ao tentar enviar ou Json Inválido';
            self::sendLog($logId, $guid, $status, $data, $resposta);
            return false;
        }
        
        if($res) {
            // Retorno do SAP
            $return['code'] = $res->getStatusCode();
            $return['data'] = $res->getBody()->getContents();

            if(isset($return['data']->MT_RetornoProcessamento_I999->RET->STATUS)){
                $retornoStatus  = $return['data']->MT_RetornoProcessamento_I999->RET->STATUS;
            }
            
            $status = 6;

            if($return['code'] == 202 || $return['code'] == 200) {
                $status = 3;
            }

            if(isset($retornoStatus) && $retornoStatus === 'E') {
                $status = 6;
            }
            
            if(isset($return['data']->MT_RetornoProcessamento_I999->RET->KEY->RET_LOG->LOG)) {
                $resposta = $return['code'].' - '.$return['data']->MT_RetornoProcessamento_I999->RET->KEY->RET_LOG->LOG;
            }

            $resposta = $return['code'];

            self::sendLog($logId, $guid, $status, $data, $resposta);
            
            if($status == 3) {
                return $return;
            }
        }
        return false;
    }
    /**
     * Functo to Set setLog Or upLog.
     *
     * @param  $data, $endpoint
     *
     * @return boolean
     */
    protected function sendLog($logId=null, $guid=null, $status=null, $payload='', $resposta=null){
        // Instancia Model de Log
        $logs = new ModelLogs;
        if($logId) {
            $logs->upLog($logId, $guid, $status, $resposta);
        } else {
            $logs->setLog($guid, $status, $payload, $resposta);
        }
    }
}
