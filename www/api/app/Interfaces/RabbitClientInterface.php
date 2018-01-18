<?php

namespace App\Interfaces;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;

//Rules
use App\Requests\Rac\EncerramentoDeContratoRule;
//Models
use App\Models\ModelLogs;

class RabbitClientInterface
{
    /**
     * Dados de Conexão do RabbitMQ
     */
    protected $connection = [];
    /**
     * Método Construtor
     */
    public function __construct() {
        $this->connection = [
            'host'      => env('RABBITMQ_HOST'),
            'vhost'     => env('RABBITMQ_VHOST'),
            'user'      => env('RABBITMQ_LOGIN'),
            'password'  => env('RABBITMQ_PASSWORD'),
        ];
    }
    /**
     * Envio de Payload para Fila do Rabbit.
     *
     * @param  $data, $endpoint
     *
     * @return boolean
     */
    public function send($data, $queue) {

        // Conexão com RabbitMQ
        $client  = (new Client($this->connection))->connect();
        // Abertura do Canal de Comunicação
        $channel = $client->channel();
        // Declaraçao do Nome da Fila no RabbitMQ
        $channel->queueDeclare($queue, false, false, false, false);
        $return  = [];
        //Loop de envio para o RabbitMQ
        foreach ($data as $payload) {
            $response = $channel->publish($payload, [], '', $queue);
            $return[] = $response;
            $json     = json_decode($payload);
            $guid     = $json->GUID;
            //Log com status de ida para RabbitMQ;
            //$logs = new ModelLogs;
            //$log  = $logs->setLog("$guid", 2, "'".$payload."'", "$response");
        }
        // Fecha conexão com RabbitMQ
        $channel->close();
        $client->disconnect();

        return $return;
    }
    /**
     * Retira Payload da Fila e Envia para SAP.
     *
     * @param $endpoint
     *
     * @return $return
     */
    public function receive($queue, $endpoint) {

        // Instancia Cliente do Rabbit MQ
        $client  = (new Client($this->connection))->connect();

        // Abre o Canal de Comunicação
        $channel = $client->channel();

        // Retira da Fila o Payload
        $message = $channel->get($queue, false);

        // Envio Payload para o SAP
        $return = [];
        if(isset($message)) {
            if($message->content) {

                // Instancia Interface com SAP
                $interface = new SapClientInterface();

                // Método de Envio do Payload para SAP
                $integrate = $interface->send($message->content , $endpoint);
            }
            // Confirma pro RabbitMQ se integrado no SAP e Trata Retornos
            if(isset($integrate) && isset($message) && $integrate['code'] == '202') {
                $return['status'] = $channel->ack($message);
                $json = json_decode($message->content, true);
                $return['guid'] = $json['GUID'];
                return $return;
            }
            return false;
        }
        return false;
        // Fecha conexão com RabbitMQ
        $channel->close();
        $client->disconnect();
    }
}
