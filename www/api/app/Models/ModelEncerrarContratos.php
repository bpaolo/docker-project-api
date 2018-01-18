<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ModelEncerrarContratos extends Model 
{
    /**
     * Nome da conexão de dados.
     *
     * @var string
     */
    protected $connection = "vetor";
    /**
     * Nome da tabela representada pelo model.
     *
     * @var string
     */
    protected $table = "C009_Contratos AS C";
    /**
     * Função que traz os contratos encerrados para integração.
     *
     * @var string
     */
    protected function Contratos($filter) {
        DB::enableQueryLog();

        $Contratos = ModelEncerrarContratos::select(
            [DB::raw("'I013' AS 'GUID',
                        'I013' AS 'COD_INTERF',
                        'DEPARA' AS 'VBELN',
                        C.Modalidade AS 'ZZTPCLIENTE', 
                        C.Upgrade AS 'ZZUPGRADE', 
                        C.ContratoNro AS 'ZZNRCONTRATO', 
                        LPAD(CS.Sequencia, 3, 0) AS 'ZZNRPERIODO', 
                        '000' AS 'ZZNRADITIVO',
                        C.ReservaID AS 'ZZNRRESERVA', 
                        IF(C.ReservaID <> '', RE.CanalID, '4') AS 'ZZTPCANAL',
                        RE.Referencia AS 'ZZCODREF', 
                        SUBSTR(REPLACE(RE.Data, '-', ''), 1, 8) AS 'ZZDTARES', 
                        SUBSTR(REPLACE(RE.Data, ':', ''), 12, 6) AS 'ZZHRARES', 
                        LF.Sigla  AS 'ZZLJRET',
                        SUBSTR(REPLACE(C.R_Data, '-', ''), 1, 8) AS 'ZZDTARET',
                        SUBSTR(REPLACE(C.R_Data, ':', ''), 12, 6) AS 'ZZHRARET',
                        C.FrotaID AS 'ZZPLACARET',
                        C.GrupoID AS 'ZZGPRET',
                        LF.Sigla AS 'ZZLJDEV',
                        SUBSTR(REPLACE(C.D_Data, '-', ''), 1, 8) AS 'ZZDTADEV',
                        SUBSTR(REPLACE(C.D_Data, ':', ''), 12, 6) AS 'ZZHRADEV',
                        C.FrotaID AS 'ZZPLACADEV',  
                        C.GrupoID AS 'ZZGPDEV',  
                        REPLACE(FORMAT(CS.ValorTotal, 2), ',', '') AS 'ZZVLTOTAL_PED',
                        SUBSTR(REPLACE(C.D_data, '-', ''), 1, 8) AS 'ZZDTAPGTO', 
                        SUBSTR(REPLACE(CS.DataFinal, '-', ''), 1, 8) AS 'ZZDTAENC',  
                        (IF(C.Modalidade <> 3, DATEDIFF(CS.DataFinal, CS.DataIni), '')) AS 'ZZDURLOC',  
                        SUBSTR(REPLACE(C.DataA, '-', ''), 1, 8) AS 'ZZDTAINI',  
                        SUBSTR(REPLACE(C.DataF, '-', ''), 1, 8) AS 'ZZDTAFIM',
                        'PENDENTE' AS 'ZZVLTOTAL',  
                        '' AS 'AUGRU',  
                        '' AS 'ZZDENTREG',
                        'BRL' AS 'WAERK',
                        '' AS 'ZTEXT_FORMAPGTO',  
                        (SELECT CL.TID
                         FROM C009_Lancamentos CL
                         WHERE CL.ContratoNro = C.ContratoNro
                              AND CL.Sequencia = CS.Sequencia
                              AND CL.Status = 1
                              AND CL.PreAutorizacao = 1
                         ORDER BY CL.DataLancto DESC
                         LIMIT 1
                        ) AS 'ZTEXT_INFO_COMPLEM',
                        
                        (SELECT 
                              GROUP_CONCAT(
                                 CONCAT('\"ITENS\":{', 
                                    IF('MATNR' <> '', @arrayItens := '\"MATNR\": \"DEPARA\"', @arrayItens := ''),
                                    IF((C.Modalidade=1 || C.Modalidade=2) , concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"KWMENG\":', '\"', CP.Qtde, '\"')), '\"KWMENG\": 1' ),
                                    IF(C.FilialIDA <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"WERKS\": ', '\"', C.FilialIDA, '\"')), ''),
                                    IF(CP.ValorUnitario <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE1\": ', '\"', FORMAT(CP.ValorUnitario, 2)), '\"'), ''),
                                    IF(CP.Desconto <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE2\": ', '\"', FORMAT(CP.Desconto, 2)), '\"'), ''),
                                    IF('PENDENCIA' <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE3\": ', '\"PENDENCIA\"')), ''),
                                    IF('PENDENCIA' <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE4\": ', '\"PENDENCIA\"')), ''),
                                    IF(CP.TaxaAdministrativa <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE6\":', '\"', FORMAT(CP.TaxaAdministrativa, 2)), '\"'), ''),
                                    IF('PENDENCIA' <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"PRCTR\": ', '\"DEPARA\"')), ''),
                                  '}'
                                 )
                              )
                             FROM C009_Produtos CP
                             WHERE CP.ContratoNro = C.ContratoNro
                                   AND CP.Sequencia = CS.Sequencia
                        ) AS 'ITENS',
                        
                        IF((C.ClienteID <> '' || C.PagadorID <> '' || C.AgenciaID <> '' || C.EmpresaID <> '' || C.UsuarioA <> '' || C.UsuarioF <> ''),
                            (CONCAT(
                                 IF(C.ClienteID <> '', @arrayParc := '\"PARCEIROS\":{ \"PARVW\": \"AG\"', @arrayParc := ''), 
                                 IF(C.ClienteID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := concat('\"KUNNR\": ', '\"', C.ClienteID, '\"', '}')),''), 
                                 
                                 IF(C.PagadorID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := '\"PARCEIROS\":{ \"PARVW\": \"RG\"'), ''), 
                                 IF(C.PagadorID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := concat('\"KUNNR\": ', '\"', C.PagadorID, '\"', '}')),''), 
                                 
                                 IF(C.AgenciaID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := '\"PARCEIROS\":{ \"PARVW\": \"ZG\"'), ''), 
                                 IF(C.AgenciaID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := concat('\"KUNNR\": ', '\"', C.AgenciaID, '\"', '}')),''), 
                                 
                                 IF(C.EmpresaID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := '\"PARCEIROS\":{ \"PARVW\": \"ZE\"'), ''), 
                                 IF(C.EmpresaID <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := concat('\"KUNNR\": ', '\"', C.EmpresaID, '\"', '}')),''), 
                                 
                                 IF(C.UsuarioA <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := '\"PARCEIROS\":{ \"PARVW\": \"ZA\"'), ''), 
                                 IF(C.UsuarioA <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := concat('\"KUNNR\": ', '\"', C.UsuarioA, '\"', '}')),''), 
                                 
                                 IF(C.UsuarioF <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := '\"PARCEIROS\":{ \"PARVW\": \"ZL\"'),''), 
                                 IF(C.UsuarioF <> '', concat(if(@arrayParc <> '', ', ', ''), @arrayParc := concat('\"KUNNR\": ', '\"', C.UsuarioF, '\"', '}')),''))
                            ),
                           '')AS PARCEIROS,
                        
                        ( SELECT 
                               GROUP_CONCAT(
                                   CONCAT('\"DADOS_PGTO\":{', 
                                      IF('DEPARA' <> '',  @arrayDP := concat('\"KUNNR\": ', '\"DEPARA\"'), @arrayDP := ''),
                                      IF('DEPARA' <> '', concat(if(@arrayDP <> '', ', ', ''), @arrayDP := concat('\"ZLSCH\": ', '\"DEPARA\"')), ''),
                                      IF('DEPARA' <> '', concat(if(@arrayDP <> '', ', ', ''), @arrayDP := concat('\"COND_VALUE5\": ', '\"', REPLACE(FORMAT(C009L.Valor, 2), ',', ''),'\"')), ''),
                                      IF(C009L.TID <> '', concat(if(@arrayDP <> '', ', ', ''), @arrayDP := concat('\"ZZTRANSACAO\": ', '\"', SUBSTR(C009L.TID, 1, 14), '\"')), ''),
                                    '}'
                                   )
                               )
                         FROM C009_Lancamentos C009L
                         WHERE C009L.ContratoNro = C.ContratoNro
                                AND C009L.Sequencia = CS.Sequencia
                                AND C009L.Status = 1
                        ) AS DADOS_PGTO")
    		])

	        ->join('C009_ContratoSeq AS CS', 'C.ContratoNro', '=', 'CS.ContratoNro')
	        ->leftJoin('C013_Reservas AS RE', 'C.ReservaID', '=', 'RE.ReservaID')
	        ->leftJoin('L005_Canais_Venda AS CV', 'RE.CanalID', '=', 'CV.CanalID')
	        ->leftJoin('L001_Filiais AS LF', 'C.R_FilialID', '=', 'LF.FilialID');

	        if(isset($filter['StatusID']) && $filter['StatusID'] != "") {
	            $Contratos->where('C.StatusID', $filter['StatusID']);
	        }
	        if(isset($filter['Sequencia']) && $filter['Sequencia'] != "") {
	            $Contratos->where('CS.Sequencia', '<=', $filter['Sequencia']);
	        }
	        if(isset($filter['DataFinal']) && $filter['DataFinal'] != "") {
	            $Contratos->where(DB::raw('SUBSTR(CS.DataFinal,1,10)'), '=', $filter['DataFinal']);
	        }

	        $Contratos->where(function($Contratos) {
	            $Contratos->where(DB::raw('SUBSTR(CS.DataFinal,1,10)'), '=', 'SUBSTR(CS.DataF,1,10)');
	            $Contratos->orWhere('CS.DataF', '<>', '');
	        });

	        if(isset($filter['limit']) && $filter['limit'] != "") {
	            $Contratos->limit($filter['limit']);
	        }
	        dd(DB::getQueryLog());
	    return $Contratos->get()->toarray();
    }
}