<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Validator;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;

class LandmarkController extends Controller
{
    /**
     * Recebimento dos envios do SAP
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Sync(Request $request, $id = null) {
        // Instancia Response
        $response   = new ResponseJson();
        // Seta a Variável Payload com o Request
        $payload    = $request->all();
        // Verifica Payload
        if($payload){
            try{


                $teste = json_encode($payload);

                $x = json_decode($teste);

                $interface = get_object_vars($x);

                //var_dump($x);

                //die();

                $caminho = 'Ops';
                foreach ($interface as $key => $val) {
                    $caminho =  $key;
                }

                DB::table('SAP_Retorno')->insert(
                    ['Payload' => $teste, 'Status' => 0, 'Interface' => $caminho]
                );
                return $response->setResponse(202, null, null);
            }catch (\Exception $e){
                return $response->setResponse(500, null, null);
            }
        }
        return $response->setResponse(500, null, null);
    }

    /**
     * Create Pedido On SAP.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Async(Request $request) {

        $response   = new ResponseJson();

        $payload = $request->all();

        if($payload){
            try{
                $teste = json_encode($payload);

                $x = json_decode($teste);

                $interface = get_object_vars($x);

                //var_dump($x);

                //die();

                $caminho = 'Ops';
                foreach ($interface as $key => $val) {
                    $caminho =  $key;
                }

                DB::table('SAP_Retorno')->insert(
                    ['Payload' => $teste, 'Status' => 0, 'Interface' => $caminho]
                );

                return $response->setResponse(202, null, null);
            }catch (\Exception $e){
                return $response->setResponse(500, null, null);
            }
        }
        return $response->setResponse(500, null, null);
    }

    public function MT_AtualizaStOKFinanceiro_I019() {

        echo 'estou no controlador de MT_AtualizaStOKFinanceiro_I019';

        die();
        $x = $request->all();

        var_dump($x);
        die();

        DB::table('F022_SAP')->insert(
            ['StatusIntegracao' => 4, 'RetornoSAP' => json_encode($x), 'MovimentacaoID' => 1]
        );
        die();
    }

    public function Teste(Request $request) {

        $response   = new ResponseJson();

        $teste = DB::table('SAP_Retorno')
            //->offset(10)
            ->limit(5)
            ->get()->toArray();


        $x = json_decode($teste[0]->Payload);

        var_dump($x);
       // die();

        $interface = get_object_vars($x);

        var_dump($interface);
        foreach ($interface as $key => $val) {
            $caminho =  $key;
        }

        echo $caminho;
        die();

        $this->$caminho();

        die();


        echo 'hauha que gambis bonita';

        $x = $request->all();

        var_dump($x);

    //        die();


        DB::table('SAP_Retorno')->insert(
            ['Payload' => json_encode($x), 'Status' => 0]
        );
        die();
    }

    public function I001(Request $request, $id = null) {

        $response   = new ResponseJson();

        $payload = $request->all();

        if($payload){
            try{
                DB::table('SAP_Retorno')->insert(
                    ['Payload' => json_encode($payload), 'Status' => 0, 'Interface' => __FUNCTION__]
                );

                return $response->setResponse(202, null, null);
            }catch (\Exception $e){
                return $response->setResponse(500, null, null);
            }
        }
        return $response->setResponse(500, null, null);

        try{
            $this->$id($x);
        }catch (\Throwable  $e) {
            return RuleRequest::response(505, 'Internal Server Error');
        }
    }

    public function I012(Request $request, $id = null) {

        $response   = new ResponseJson();

        $payload = $request->all();

        if($payload){
            try{
                DB::table('SAP_Retorno')->insert(
                  ['Payload' => json_encode($payload), 'Status' => 0, 'Interface' => __FUNCTION__]
                );

                $encode = json_encode($payload);
                $retorno = json_decode($encode);


                $contrato = explode('/', $retorno->MT_RetornoProcessamento_I999->RET->KEY->KEYNR);

                DB::table('C009_ContratoSeq_A')->insert(
                    ['ContratoNro' => $contrato[0],
                        'Sequencia'=> 1,
                        'IntegracaoID' => 1,
                        'DataIntegracao' => '',
                        'NroOrdemDeVenda' => $retorno->MT_RetornoProcessamento_I999->RET->KEY->RET_LOG->DOCNUM]
                );

                var_dump($retorno);
                die();

                DB::table('C009_ContratoSeq_A')
                    //->whereIn('IntegracaoID', $movimentacoes )
                    ->where('CodigoSAP', $retorno->MT_RetornoProcessamento_I999->VBELN)
                    ->update(['StatusIntegracao' => $retorno->MT_RetornoProcessamento_I999->MVGR1]);

                return $response->setResponse(202, null, null);
            }catch (\Exception $e){
                return $response->setResponse(500, null, null);
            }
        }
        return $response->setResponse(500, null, null);
    }

    public function I019(Request $request, $id = null) {

        $response   = new ResponseJson();

        $payload = $request->all();

        if($payload){
            try{
                DB::table('SAP_Retorno')->insert(
                    ['Payload' => json_encode($payload), 'Status' => 0, 'Interface' => __FUNCTION__]
                );

                $encode = json_encode($payload);
                $retorno = json_decode($encode);

                //var_dump($retorno);
               // die();

                 DB::table('SN003_PedidoVenda_A')
                    //->whereIn('IntegracaoID', $movimentacoes )
                    ->where('CodigoSAP', $retorno->MT_AtualizaStOKFinanceiro_I019->VBELN)
                    ->update(['StatusIntegracao' => $retorno->MT_AtualizaStOKFinanceiro_I019->MVGR1]);

                return $response->setResponse(202, null, null);
            }catch (\Exception $e){
                return $response->setResponse(500, null, null);
            }
        }
        return $response->setResponse(500, null, null);

    }

    public function I023(Request $request, $id = null) {

        $response   = new ResponseJson();

        $payload = $request->all();

        if($payload){
            try{
                //DB::table('SAP_Retorno')->insert(
                  //  ['Payload' => json_encode($payload), 'Status' => 0, 'Interface' => __FUNCTION__]
                //);

                $encode = json_encode($payload);
                $retorno = json_decode($encode);

                var_dump($retorno);
                 die();

                DB::table('SN003_PedidoVenda_A')
                    //->whereIn('IntegracaoID', $movimentacoes )
                    ->where('CodigoSAP', $retorno->MT_AtualizaStOKFinanceiro_I019->VBELN)
                    ->update(['StatusIntegracao' => $retorno->MT_AtualizaStOKFinanceiro_I019->MVGR1]);

                return $response->setResponse(202, null, null);
            }catch (\Exception $e){
                return $response->setResponse(500, null, null);
            }
        }
        return $response->setResponse(500, null, null);

    }

}