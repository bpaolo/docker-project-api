<?php

namespace App\Consumers;

use App\Consumers\Contracts\HandlesPayload;

abstract class AbstractConsumer implements HandlesPayload
{
    /**
     * Consumer Function.
     *
     * @param mixed payload
     * @return void
     */
    public function handle($payload){
        return $this->consume($payload);
    }
    abstract protected function consume($payload);
}