<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ModelLogs extends Model 
{
    /**
     * Nome da conexão de dados.
     *
     * @var string
     */
    protected $connection = 'log';
    /**
     * Primary.
     *
     * @var int
     */
    protected $primaryKey = 'id';
    /**
     * Nome da tabela representada pelo model.
     *
     * @var string
     */
    protected $table = 'T025_IntegracaoSAP';
    /**
     * Atributos que podem ser exibidos no Select.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'Guid',
        'StatusIntegracao',
        'DataIntegracao',
        'DataAtualizacao',
        'Payload',
        'RespostaIntegracao'
    ];
    /**
     * Constantes de Criação e Atualização dos Dados.
     *
     */
    const CREATED_AT = 'DataIntegracao';
    const UPDATED_AT = 'DataAtualizacao';
    /**
     * Get Log por GUID
     *
     * @param  $id
     *
     * @return $logs
     */
    public function getLog($guid) {

        $logs = $this->where('guid', 'like', $guid)->first();
        if($logs) {
            $logs = $logs->id;
            return $logs;
        }
        return null;
    }
    /**
     * Insert Log
     *
     * @param  $guid
     * @param  $status
     * @param  $payload
     * @param  $resposta
     *
     * @return $logs
     */
    public function setLog($guid=null, $status=null, $payload=null, $resposta=null) {

        // Possíveis Status da Integração
        // 1 - Pronto para Integração
        // 2 - Na fila para integração
        // 3 - Aguardando Integração
        // 4 - Aguardando Integração com Dependência
        // 5 - Integrado
        // 6 - Erro de Integração
        $log                     = new ModelLogs;
        $log->Guid               = $guid;
        $log->StatusIntegracao   = $status;
        $log->Payload            = $payload;
        $log->RespostaIntegracao = $resposta;
        $logs                    = $log->save();

        if($logs){
            $logs = $log->Guid;
        }
        return $logs;
    }
    /**
     * Update Log
     *
     * @param  $id
     * @param  $guid
     * @param  $status
     * @param  $payload
     * @param  $resposta
     *
     * @return $logs
     */
    public function upLog($id=null, $guid=null, $status=null, $resposta=null) {

        if($id) {
            $log = ModelLogs::find($id);
            if($log) {
                if(isset($guid)) {
                    $log->Guid = $guid; 
                }
                if(isset($status)) {
                    $log->StatusIntegracao = $status;
                }
                if(isset($resposta)) {
                    $log->RespostaIntegracao = $resposta;
                }
                $logs = $log->save();
                return $logs;
            }
            return false;
        }
        return false;
    }
}