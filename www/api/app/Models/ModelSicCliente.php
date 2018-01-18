<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelSicClente extends Model
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
    protected $table = "A001_Moedas";
    /**
     * Nome do campo da chave primária.
     *
     * @var string
     */
    protected $primaryKey = "PedidoID";
    /**
     * Atributos que podem ser exibidos no Select.
     *
     * @var array
     */
    protected $fillable = [
        'PedidoID',
        'VendedorID',
        'ValorVenda',
        'ValorDesconto',
    ];
    /**
     * Lista todos os usuários.
     *
     * @var array
     */
    public function allUser() {
        $users = DB::select('select * from $table');
        return $users;
    }
}
