<?php

return [

    'use' => 'production',

    'properties' => [

        'production' => [
            'host'                  => env('RABBITMQ_HOST',''),
            'port'                  => env('RABBITMQ_PORT',''),
            'username'              => env('RABBITMQ_LOGIN','guest'),
            'password'              => env('RABBITMQ_PASSWORD','guest'),
            'vhost'                 => '/',
            'exchange'              => 'amq.topic',
            'exchange_type'         => 'topic',
            'exchange_durable'      => true,
            'consumer_tag'          => 'consumer',
            'ssl_options'           => [], // See https://secure.php.net/manual/en/context.ssl.php
            'connect_options'       => [], // See https://github.com/php-amqplib/php-amqplib/blob/master/PhpAmqpLib/Connection/AMQPSSLConnection.php
            'queue_properties'      => ['x-ha-policy' => ['S', 'all']],
            'exchange_properties'   => [],
            'timeout'               => 0
        ],

    ],

];
