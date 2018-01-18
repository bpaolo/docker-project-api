<?php

namespace App\Consumers\Rac;

// Abstracts
use App\Consumers\AbstractConsumer;
// Models
use App\Models\Rac\ModelMaterial;

class EnviaMaterialConsumer extends AbstractConsumer
{
	protected function consume($payload) {

        $model   = new ModelMaterial();
        return $model->insertMaterial($payload);
		
	}
}