<?php

namespace App\Http\Controllers;
// Helpers
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Validator;
use App\Responses\ResponseJson;
// Rules
use App\Requests\RuleRequest;
use App\Requests\MovimentacaoAtivosRule;
use App\Requests\CancelaVendaAtivoRule;
use App\Requests\CancelaVendaCartaoRule;
use App\Models\ModelFrota;
use App\Models\ModelLancamento;
// Consumers
use App\Consumers\MovimentacaoAtivosConsumer;
use App\Consumers\CancelaVendaCartaoConsumer;
// Models
use App\Models\ModelFrota;
use App\Models\ModelLancamento;

class AtivosController extends Controller
{
    /**
     * Movimentação de Status de Frota no SAP. -|- Interface I024
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Movimentacao(Request $request) {
        // Instancia Response
        $response  = new ResponseJson();
        /**
         * Verifica na tabela de integração as movimentações que mudaram o grupo de status(PIMP, OPER,
         * ROUB, DVEN, SINS, VEND) e envia ao SAP.
         */
        try{
            
            $itens      = ModelFrota::AllMovimentacoesParaIntegrar();
            $consumer   = new MovimentacaoAtivosConsumer();
            $integrate  = $consumer->handle($itens);
            $response   = $integrate;

        }catch (\Exception $e) {
            return $response->setResponse(500, null, null);
        }
        return $response->setResponse(202, null, $response);
    }

    public function Teste(Request $request) {
        // Instancia Response
        $response  = new ResponseJson();
        // Valida se a Request é Válida
        $naoValidou = RuleRequest::isValid($request->all(), CancelaVendaAtivoRule::$rules);
        // Retorno da Validação do Request
        if($naoValidou) {
            return $response->setResponse(400, null, null);
        }
        // Instancia o Consumer ?
        $consumer   = new MovimentacaoAtivosConsumer();
        // Envia o Payload para o Consumer ?
        $integrate  = $consumer->handle('F022_SAP');
        // Verifica a integração
        if($integrate) {
            return $response->setResponse(202, null, $integrate);
        }
        return $response->setResponse(500, null, null);
    }

    public function Cancelamento(Request $request) {
        // Instancia Response
        $response = new ResponseJson();
        // Instancia SAP Cliente ?
        $envioSAP = new SapClientInterface();
        // Faz select no Banco ?
        $teste = ModelLancamento::limit(100)
            //->where('SN003_Lancamentos.CartaoID' , '!=', null)
            //->where('SN003_Lancamentos.FormaID' , '=', 3)
            ->whereIn('SN003_Lancamentos.FormaID', [3, 9])
            //->where('SN003_Lancamentos.FormaID' , '=', 9)
            //->get()->toArray();
            ->leftJoin('B004_Pessoas_CC', 'B004_Pessoas_CC.CartaoID', '=', 'SN003_Lancamentos.CartaoID')
            ->leftJoin('B014_Bandeiras', 'B014_Bandeiras.BandeiraID', '=', 'B004_Pessoas_CC.BandeiraID')
            ->leftJoin('B014_Operadoras', 'B014_Operadoras.OperadoraID', '=', 'SN003_Lancamentos.TPOS')
            ->leftJoin('SN003_PedidoVenda', 'SN003_PedidoVenda.PedidoID', '=', 'SN003_Lancamentos.PedidoID')
            ->get()->toArray();
        // Instancia Consumer ?
        $consumer   = new CancelaVendaCartaoConsumer();
        // Envia Payload para Consumer ?
        $integrate  = $consumer->handle($teste);
        // Verifica a integração
        if($integrate) {
            return $response->setResponse(202, null, null);
        }
        return $response->setResponse(500, null, null);
    }
}
