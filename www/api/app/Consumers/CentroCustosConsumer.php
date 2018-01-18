<?php

namespace App\Consumers;

use Illuminate\Support\Facades\DB;
// Abstracts
use App\Consumers\AbstractConsumer;
// Client
use App\Interfaces\SapClientInterface;
// Rules
use App\Requests\CentroCustosRule;

class CentroCustosConsumer extends AbstractConsumer
{
	
	protected function consume($payload) {

        try{
	        $idIntegrado = array();
            foreach ($payload as $item) {
                $integrate[$item->IntegracaoID] = SapClientInterface::send(CentroCustosRule::parseDB($item), MovimentacaoAtivosRule::$endpoint);

                if(($integrate[$item->IntegracaoID]['code']??false) == 202) {
                    $idIntegrado[] = $item->IntegracaoID;
                    //throw new \Exception('integrou');
                }else{
                    throw new \Exception('Não integrou');
                }
                //throw new \Exception('Não integrou');
            }
            DB::table('F022_SAP')
                //->where('IntegracaoID', $item->IntegracaoID )
                ->whereIn('IntegracaoID', $idIntegrado )
                ->update(['StatusIntegracao' => 3]);
        }catch (Exception $e){
	        echo 'teste';
	        echo $e;
	        //die();
        }

        return true;
	}

}
