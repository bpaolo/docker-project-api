<?php

namespace App\Models\Rac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelMaterial extends Model
{
    /**
     * Nome da conexão de dados.
     *
     * @var string
     */
    protected $connection = "vetor";
    /**
     * Função de Inserção de material no vetor.
     *
     * @var $obj
     */
    public function insertMaterial($data) {


        try {
            DB::transaction(function () use ($data) {
                $descricao   = $data['Descricao'];
                $ativo       = $data['Ativo'];
                $pmo         = $data['PMO'];
                $codigoSAP   = $data['CodigoSAP'];

                DB::insert("INSERT INTO F017_OSListaItens
                            (`Descricao`,`Ativo`,`PMO`,`CodigoSAP`)
                            VALUES
                            ('".$descricao."',".$ativo.",".$pmo.",".$codigoSAP.");");
                });
        }
        catch (\Exception $e) {
            return $e->getMessage('Erro no processo! Dados não Inseridos');
        }
    }

}
