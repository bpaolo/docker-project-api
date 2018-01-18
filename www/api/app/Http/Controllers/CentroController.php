<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Validator;
use App\Responses\ResponseJson;
//Rules
use App\Requests\RuleRequest;
use App\Requests\CentroCustosRule;
use App\Requests\CancelaVendaAtivoRule;
use App\Requests\CancelaVendaCartaoRule;
//Consumers
use App\Consumers\CentroCustosConsumer;
use App\Consumers\CancelaVendaCartaoConsumer;
//Models

class CentroController extends Controller
{
    /**
     * Create Movimentação de Pedido no SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Cadastro(Request $request) {

        $response  = new ResponseJson();

        $teste2 = DB::table('F022_SAP')
            ->limit(1)
            ->where('IntegracaoID' , '=', 11)
            ->get()->toArray();

        //var_dump($teste2);
        //die();

        $ok = json_decode($teste2[0]->RetornoSAP);

        var_dump($ok);
        //die();

        DB::table('A002_CentroCustos')->insert(
            ['CodigoCentroCustoSAP'    => $ok->CENTRO_LUCROS->KOSTL,
                'TipoCentroCustos'     => $ok->CENTRO_LUCROS->KOSAR,
                'DescTipoCentroCustos' => $ok->CENTRO_LUCROS->KTEXT,
                'DescricaoSAP'         => $ok->CENTRO_LUCROS->LTEXT,
                'Permite_Lancamento'   => $ok->CENTRO_LUCROS->BKZKP,
                'BloqueadoRateio'      => $ok->CENTRO_LUCROS->BKZKS,
                'ValidadeIni'          => $ok->CENTRO_LUCROS->DATAB,
                'ValidadeFim'          => $ok->CENTRO_LUCROS->DATAI,
                'ResponsavelSAP'       => $ok->CENTRO_LUCROS->NAME4]
        );

        die();
        $consumer   = new CentroCustosConsumer();
        $integrate  = $consumer->handle($ok);

        if($integrate){

            var_dump($integrate);
            die();

            $rsap    = json_decode($integrate['data']);
            $rsap    = $rsap->MT_RetornoProcessamento_I999;
            $guid    = $rsap->GUID;
            $status  = $rsap->RET->STATUS;

            if($status == 'S'){

                $docnum = $rsap->RET->KEY->KEYNR;

                return $response->setResponse(201, null, $docnum);
            }

            if($status == 'E'){

                $message = $rsap->RET->KEY->RET_LOG->LOG->MESSAGE;

                return $response->setResponse(422, $message, null);
            }
        }
        return $response->setResponse(500, null, null);
    }
}