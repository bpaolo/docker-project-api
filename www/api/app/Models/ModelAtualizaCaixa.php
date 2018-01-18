<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelAtualizaCaixa extends Model
{
    /**
     * Nome da conexão de dados.
     *
     * @var string
     */
    protected $connection = "vetor";
    /**
     * Função de Atualização do Pagamento.
     *
     * @var $obj
     */
    public function updatePay($data) {

        #update only
        $setDataUpdate = $this->setDataBox($data);

        try {
            DB::transaction(function () use ($setDataUpdate) {

                DB::update("update C009_Lancamentos_A
                    set 
                    ".$setDataUpdate['LctoID']."
                    ".$setDataUpdate['DtIntegracao']."
                    ".$setDataUpdate['StatusIntegracao']."
                    ".$setDataUpdate['IntegracaoID']."
                    ".$setDataUpdate['CodigoSAP']."
                    where LctoAID = ".$setDataUpdate['LctoAID']);
                });
        }
        catch (\Exception $e) {
            return $e->getMessage('Erro no processo! Dados não atualizados');
        }
    }
    /**
     * Função de verificação dos dados de atualização.
     *
     * @var $obj
     */
    private function setDataBox($dataUpdatePay) {

        $LctoID             = $dataUpdatePay['LctoID'];
        $DtIntegracao       = $dataUpdatePay['DtIntegracao'];
        $StatusIntegracao   = $dataUpdatePay['StatusIntegracao'];
        $IntegracaoID       = $dataUpdatePay['IntegracaoID'];
        $CodigoSAP          = $dataUpdatePay['CodigoSAP'];

        //mandatory parameters
        $data['LctoAID']            = $dataUpdatePay['LctoAID'];
        $data['LctoID']             = ($dataUpdatePay['LctoID']         ?   "LctoID         =   $LctoID" : '');

        //not mandatory
        $data['DtIntegracao']       = ($dataUpdatePay['DtIntegracao']   ?   ", DtIntegracao   =   '$DtIntegracao'" : '');
        $data['StatusIntegracao']   = ($dataUpdatePay['StatusIntegracao']  ? ",StatusIntegracao = '$StatusIntegracao'" : '');
        $data['IntegracaoID']       = ($dataUpdatePay['IntegracaoID']   ?   ", IntegracaoID   =   '$IntegracaoID'" : '');
        $data['CodigoSAP']          = ($dataUpdatePay['CodigoSAP']      ?   ", CodigoSAP      =   '$CodigoSAP'" : '');

        return $data;
    }
}
