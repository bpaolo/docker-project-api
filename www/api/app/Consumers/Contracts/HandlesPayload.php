<?php

namespace App\Consumers\Contracts;

interface HandlesPayload
{
    public function handle($payload);
}