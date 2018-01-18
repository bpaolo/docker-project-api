<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLancamento extends Model
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
    protected $table = "SN003_Lancamentos";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "NroLancamento";
    /**
     * Atributos que podem ser exibidos no Select.
     *
     * @var array
     */
    protected $fillable = [
        'DataLancto',
        'DTIntegracao',
        'TID',
        'BandeiraID',
        'Valor',
        'Origem',
        'NroParcelas',
        'Estabelecimento',
    ];
}
