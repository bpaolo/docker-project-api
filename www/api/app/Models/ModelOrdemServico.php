<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelOrdemServico extends Model
{
    /**
     * Nome da conexão de dados.
     *
     * @var string
     */
    protected $connection = "vetor";
    
    const ERROR = 'Internal Server Error';

    public function __construct() {
        DB::enableQueryLog();
    }
    /**
     * Função que leva ordem de serviços para rabbitMQ.
     *
     * @var string
     */
    public static function OrderService() {

        try {
            $ordemServico =  DB::select("SELECT
                               'string123' as TP_PROC,
                               'string123' as EBELN,
                               P1.IDIntegracaoSAP as LIFNR, 
                               'string123' as TP_ORD_SERV_VETOR,
                               ( SELECT 
                                      GROUP_CONCAT(
                                         CONCAT('\"ITEM\":{',
                                         IF(\"string123\" <> '', @arrayItens := CONCAT('\"MATNR\":','\"',\"string123\",'\"'), @arrayItens := ''),
                                             concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"WERKS\":', '\"string123\"')),
                                             concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"LGORT\":', '\"9000\"')),
                                              IF(OS.ServicoID <> '', @arrayItens := concat(if(@arrayItens <> '', ', ', ''), concat('\"BEDNR\":', OS.ServicoID)),''),
                                              IF(OI.Quantidade <> '', @arrayItens := concat(if(@arrayItens <> '', ', ', ''), concat('\"MENGE\":', OI.Quantidade)),''),
                                              IF(OS.ValorTotal <> '', @arrayItens := concat(if(@arrayItens <> '', ', ', ''), concat('\"NETWR\":', OS.ValorTotal)),''),
                                              concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"MWSKZ\":', '\"ZB\"')),
                                              concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"KNTTP\":', '\"F\"')),
                                              /*IF(CC.CentroCustoSAP <> '', @arrayItens := concat(if(@arrayItens <> '', ', ', ''), concat('\"KOSTL\":', CC.CentroCustoSAP)),''),*/
                                              concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"KOSTL\":', '\"string123\"')),
                                              concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"AUFNR\":', '\"string123\"')),
                                           '}'
                                         )
                                         
                                      )
                            
                                      FROM F017_OSItens OI
                                      INNER JOIN F016_OS as OS ON OS.ServicoID = OI.ServicoID
                                      INNER JOIN B004_Pessoas P  ON P.PessoaID = OI.PessoaID
                            
                                      WHERE OS1.ServicoID = OS.ServicoID
                                ) AS ITEM
                               
                                  
                                FROM F016_OS as OS1
                                INNER JOIN F017_OSItens OI1 ON OS1.ServicoID = OI1.ServicoID
                                INNER JOIN B004_Pessoas P1  ON P1.PessoaID = OI1.PessoaID
                                WHERE OS1.ServicoID = 413976 limit 1
                                                    ");

            return $ordemServico;
        }
        catch (\Exception $e) {
            return $e->getMessage('Erro no processo!');
        }
    }
}
