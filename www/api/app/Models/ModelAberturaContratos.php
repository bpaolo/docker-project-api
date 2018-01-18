<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelAberturaContratos extends Model
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
     * Função que traz os contratos abertos para integração.
     *
     * @var string
     */
    public static function C009_Contratos($filter) {

        $dataAtual = $filter['dataAtual'];
        $Sequencia = $filter['Sequencia'];
        $StatusID  = $filter['StatusID'];

        DB::statement('SET SESSION group_concat_max_len = 1000000');
        $Contratos=DB::table('C009_Contratos AS C')
            ->select([
                 DB::raw("                 
                    'I012' AS COD_INTERF,
                    'ZLO2' AS TIPO_ORDEM,                   
                    C.Modalidade AS ZZTPCLIENTE,                 
                    C.Upgrade AS ZZUPGRADE,                 
                    C.ContratoNro AS ZZNRCONTRATO,
                    CS.Sequencia AS ZZNRPERIODO, 
                    
                    if(CS.Sequencia >= 101, CS.Sequencia, '00') AS ZZNRADITIVO,
  
                    C.ReservaID AS ZZNRRESERVA,
                    IF(CV.CanalID='', 4, CV.CanalID) AS ZZTPCANAL,
                    RE.Referencia AS ZZCODREF,
                    DATE_FORMAT(RE.Data,'%Y%m%d') AS ZZDTARES,
                    DATE_FORMAT(RE.Data,'%H%i%s') AS ZZHRARES,

                    FI.Sigla AS ZZLJRET,                                    
                    DATE_FORMAT(C.R_Data,'%Y%m%d') AS ZZDTARET,
                    DATE_FORMAT(C.R_Data,'%H%i%s') AS ZZHRARET,
                    
                    (SELECT PLACA FROM F001_Frotas WHERE FrotaID = C.FrotaID) AS  ZZPLACARET,
                    C.GrupoID AS ZZGPRET,                                      

                    FI.Sigla AS ZZLJDEV,
                    DATE_FORMAT(C.D_Data,'%Y%m%d') AS ZZDTADEV,
                    DATE_FORMAT(C.D_Data,'%H%i%s') AS ZZHRADEV,
                    (SELECT PLACA FROM F001_Frotas WHERE FrotaID = C.FrotaID) AS  ZZPLACADEV,
                    C.GrupoID AS ZZGPDEV,
                    
                    (SELECT
                    REPLACE(FORMAT( sum(((CP.ValorUnitario * CP.Qtde)-CP.Desconto)+CP.TaxaAdministrativa),2), ',', '')
                    FROM C009_Produtos CP
                    WHERE CP.ContratoNro = C.ContratoNro
                    AND CP.Sequencia = CS.Sequencia ) AS 'ZZVLTOTAL_PED',

                    DATE_FORMAT(C.D_Data,'%Y%m%d') AS ZZDTAPGTO,
                              
                    DATE_FORMAT(CS.DataFinal,'%Y%m%d') AS ZZDTAENC,  
                    
                    IF(C.Modalidade <> 3, DATEDIFF(CS.DataFinal, CS.DataIni), '1')  AS ZZDURLOC,  
                                                                                       
                    DATE_FORMAT(C.DataA,'%Y%m%d') AS ZZDTAINI,
                    DATE_FORMAT(C.DataF,'%Y%m%d') AS ZZDTAFIM,
                    
                    C.ValorID AS ZZVLTOTAL,
                    'BRL' AS WAERK,
                    'Z000' AS PMNTTRMS,
                    
                    (select GROUP_CONCAT(
                    concat(
                        BFP.Descricao,'|',C009L.Valor,'|',C009L.NroParcelas
                    )
                    SEPARATOR '|') as v from  
                    C009_Lancamentos C009L
                    INNER JOIN B013_FormasPagto AS BFP ON C009L.FormaID = BFP.FormaID
                    LEFT JOIN B004_Pessoas_A AS BP ON BP.PessoaID = C009L.PessoaID
                    WHERE C009L.ContratoNro = C.ContratoNro
                    AND C009L.Sequencia = CS.Sequencia
                    AND PreAutorizacao <> 1
                    AND C009L.Status = 1) AS ZTEXT_FORMAPGTO,
                                       
                    C.Obs AS 'ZTEXT_INFO_COMPLEM',
                    '' AS PMNTTRMS                  
               "),

                DB::raw("
                
                (SELECT
                     GROUP_CONCAT(
                        CONCAT('\"ITENS\":{',
                       
                           IF(LPA.CodigoSAP <> '', @arrayItens := CONCAT('\"MATNR\":', '\"', LPA.CodigoSAP, '\"') , @arrayItens := ''),
                           
                           IF((C.Modalidade=1 || C.Modalidade=2) , concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"KWMENG\": ', '\"', CP.Qtde, '\"')), '\"KWMENG\": \"1\"' ),
                           IF(C.FilialIDA <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"WERKS\": ', '\"', C.FilialIDA, '\"')), ''),
                           IF(CP.ValorUnitario <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE1\": ', '\"', CONVERT(FORMAT(CP.ValorUnitario, 2) USING utf8)), '\"'), ''),
                           IF(CP.Desconto <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE2\": ', '\"', CONVERT(FORMAT(CP.Desconto, 2) USING utf8)), '\"'), ''),
                           
                           IF(O.FormaID = 7, concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE3\": ', IFNULL(CONVERT(FORMAT(CP.ComissaoAG, 2) USING utf8), 0) )), ''),
                           
                           IF((O.FormaID = 1 || O.FormaID = 3 || O.FormaID = 9), concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE4\": ', IFNULL(CONVERT(FORMAT(CP.ComissaoAG, 2) USING utf8), 0) )), ''),
                           
                           IF(CP.TaxaAdministrativa <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"COND_VALUE6\": ', '\"', CONVERT(FORMAT(CP.TaxaAdministrativa, 2) USING utf8)), '\"'), ''),
                           
                           IF(LF.CentroCustoSAP <> '', concat(if(@arrayItens <> '', ', ', ''), @arrayItens := concat('\"PRCTR\": ', '\"', LF.CentroCustoSAP , '\"')), ''),
                         '}'
                        )
                     )
                    FROM C009_Produtos CP
                    INNER JOIN C009_Contratos AS CC ON CP.ContratoNro = CC.ContratoNro
                    INNER JOIN C009_ContratoSeq B ON B.ContratoNro = CC.ContratoNro
                    INNER JOIN C009_Lancamentos O ON CC.ContratoNro = O.ContratoNro AND B.Sequencia = O.Sequencia
                   
                    LEFT JOIN L001_Filiais AS LF ON LF.FilialID = CC.R_FilialID
                   
                    LEFT JOIN L008_Produtos_A AS LPA ON CP.ProdutoID = LPA.ProdutoID
                   
                    LEFT JOIN B004_Pessoas D ON CC.AgenciaID = D.PessoaID
                    LEFT JOIN B004_Pessoas E ON CC.EmpresaID = E.PessoaID  

                    WHERE CP.ContratoNro = C.ContratoNro
                          AND CP.Sequencia = CS.Sequencia
                          AND O.PreAutorizacao <> 1
               ) AS 'PRO',
                            
                 
                         
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
                 '')AS PAR,
                 
                 (
                 SELECT 
                 concat('[',                 
                      GROUP_CONCAT(
                         CONCAT('{\"DADOS_PGTO\":{', 
                            IF(BP.PessoaSAP IS NOT NULL, concat(if(@array IS NOT NULL, '',''), @array := concat('\"KUNNR\": ', '\"','BP.PessoaSAP','\"')), @array := '\"KUNNR\": \"\"'),
                            IF(BFP.CodigoSAP IS NOT NULL, concat(if(@array IS NOT NULL, ',',''), @array := concat('\"ZLSCH\": ', '\"','BFP.CodigoSAP','\"')), ''),
                            IF('DEPARA' IS NOT NULL, concat(if(@array IS NOT NULL, ', ', ''), @array := concat('\"COND_VALUE5\": ', '\"', REPLACE(FORMAT((C009L.Valor * IF( C009L.NroParcelas=0,1,C009L.NroParcelas ) ), 2), ',', ''),'\"')), ''),
                            IF(C009L.TID IS NOT NULL, concat(if(@array IS NOT NULL, ', ', ''), @array := concat('\"ZZTRANSACAO\": ', '\"', C009L.TID, '\"')), ''),
                            IF(C009L.FormaID IS NOT NULL, concat(if(@array IS NOT NULL, ', ', ''), @array := concat('\"FORMAID\": ', '\"', C009L.FormaID, '\"')), ''),
                          '}}'
                         )
                      ),']')
                 FROM C009_Lancamentos C009L
                 INNER JOIN B013_FormasPagto AS BFP ON C009L.FormaID = BFP.FormaID
                 LEFT JOIN B004_Pessoas_A AS BP ON BP.PessoaID = C009L.PessoaID
                 WHERE C009L.ContratoNro = C.ContratoNro
                      AND C009L.Sequencia = CS.Sequencia
                      AND PreAutorizacao <> 1
                      AND C009L.Status = 1
                ) AS LANC
                

               "),
            ])
            ->join('C009_ContratoSeq AS CS', 'C.ContratoNro', '=', 'CS.ContratoNro')
            ->join('L001_Filiais AS FI', 'FI.FilialID', '=', 'C.FilialIDA')
            ->leftJoin('C013_Reservas AS RE', 'C.ReservaID', '=', 'RE.ReservaID')
            ->leftJoin('L005_Canais_Venda AS CV', 'RE.CanalID', '=', 'CV.CanalID');

             //$Contratos->where('CE.Status', '=', '1');

             if(isset($StatusID) && $StatusID == '') {
                 $Contratos->where('CS.StatusID', '=', $StatusID);
             }

            //->whereNull('CS.IntegracaoID');

            if(isset($Sequencia)) {
                if($Sequencia == 100){
                    $Contratos->where('CS.Sequencia', '<=', $Sequencia);
                }else{
                    $Contratos->where('CS.Sequencia', '>=', $Sequencia);
                }
            }

            //$Contratos->where('C.ContratoNro', '=', '5583872');

            $Contratos->where(function($Contratos) use($dataAtual) {
                $Contratos->where(DB::raw('SUBSTR(CS.DataIni,1,10)'), '=', $dataAtual);
            });

            $Contratos->limit(10);

        return $Contratos->get()->toArray();
    }
}
