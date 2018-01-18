<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelFrota extends Model
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
    protected $table = "F001_Frotas";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "FrotaID";
    /**
     * Atributos que podem ser exibidos no Select.
     *
     * @var array
     */
    protected $fillable = [
        'FrotaID',
        'Chassi',
        'Placa',
        'L001_FilialID_Atual',
        'StatusID',
        'Renavam'
    ];
    /**
     * Função que busca todas as movimentações para integração.
     *
     * @var array
     */
    public static function AllMovimentacoesParaIntegrar() {

        $movimentacoes = DB::table('F022_SAP')
            ->join('F022_Movimentacoes', 'F022_SAP.MovimentacaoID', '=', 'F022_Movimentacoes.MovtoID')
            ->join('F001_Frotas', 'F001_Frotas.FrotaID', '=', 'F022_Movimentacoes.F001_FrotaID')
            ->get()->toArray();
        return $movimentacoes;
    }
    /**
     * Update das movimentações integrações.
     *
     * @var array
     */
    public static function IntegraMovimentacoes($movimentacoes) {
        $ok =  DB::table('F022_SAP')
            ->whereIn('IntegracaoID', $movimentacoes )
            ->update(['StatusIntegracao' => 170]);
        return $ok;
    }

}
