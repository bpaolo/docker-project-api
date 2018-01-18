<?php

namespace App\Consumers;

// Abstracts
use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\CancelaVendaCartaoRule;

class CancelaVendaCartaoConsumer extends AbstractConsumer
{
	protected function consume($payload) {
	    var_dump(CancelaVendaCartaoRule::parseDB($payload));

        $client 	= new SapClientInterface();
        $integrate 	= $client->send(json_encode(CancelaVendaCartaoRule::parseDB($payload)), CancelaVendaCartaoRule::$endpoint);

        return $integrate;
	}
}
