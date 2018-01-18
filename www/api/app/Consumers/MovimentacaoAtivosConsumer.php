<?php

namespace App\Consumers;

use Illuminate\Support\Facades\DB;
// Abstracts
use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\RuleRequest;
use App\Requests\MovimentacaoAtivosRule;
// Models
use App\Models\ModelFrota;

class MovimentacaoAtivosConsumer extends AbstractConsumer
{
	protected function consume($payload) {

        $idIntegrado = array();

        try{
            foreach ($payload as $item) {

                $envioSAP = new SapClientInterface();

                $integrate[$item->IntegracaoID] = $envioSAP->send(json_encode(MovimentacaoAtivosRule::parseDB($item)), MovimentacaoAtivosRule::$endpoint);

                if(($integrate[$item->IntegracaoID]['code']??false) == 202) {
                    $idIntegrado[] = $item->IntegracaoID;
                }
            }

            DB::beginTransaction();

            ModelFrota::IntegraMovimentacoes($idIntegrado);

            DB::commit();
        }catch (\Exception $e) {

            echo $e;
            DB::rollBack();
        }finally {
            //echo 'teste';
        }
        return RuleRequest::response(202, 'Aguardando Integração');
	}
}
