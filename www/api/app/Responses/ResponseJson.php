<?php

namespace App\Responses;

class ResponseJson extends AbstractResponse
{
    /**
     * Função que Retorna o Json
     *
     * @return array
     */
    public function response($code=null, $errors=null, $data=null) {

        // Seta o Code no Header
        $this->response['header'] = ['code' => $code];
        // Seta o Array de Errors no Header
        if($errors) {
            $this->response['header']['errors'] = $errors;
        }
        // Seta a Message no Header
        $message = $this->setHttpCode($code);
        if($message){
            $this->response['header']['message'] = $message;
        }
        // Seta o Array de Dados no Data
        if($data) {
            $this->response['data'] = $data;
        }
        return response()->json($this->response, $code);
    }
    /**
     * Função Privada de Status
     *
     * @return string
     */
    protected function setHttpCode($code=null) {
        
        $this->http_message = [
            '100' => 'Continuar',
            '101' => 'Mudando protocolos',
            '102' => 'Processamento (WebDAV) (RFC 2518)',
            '122' => 'Pedido-URI muito longo',

            '200' => 'OK',
            '201' => 'Criado',
            '202' => 'Aceito',
            '203' => 'não-autorizado (desde HTTP/1.1)',
            '204' => 'Nenhum conteúdo',
            '205' => 'Reset',
            '206' => 'Conteúdo parcial',
            '207' => '-Status Multi (WebDAV) (RFC 4918)',

            '300' => 'Múltipla escolha',
            '301' => 'Movido',
            '302' => 'Encontrado',
            '304' => 'Não modificado',
            '305' => 'Use Proxy (desde HTTP/1.1)',
            '306' => 'Proxy Switch',
            '307' => 'Redirecionamento temporário (desde HTTP/1.1)',

            '400' => 'Requisição inválida',
            '401' => 'Não autorizado',
            '402' => 'Pagamento necessário',
            '403' => 'Proibido',
            '404' => 'Não encontrado',
            '405' => 'Método não permitido',
            '406' => 'Não Aceitável',
            '407' => 'Autenticação de proxy necessária',
            '408' => 'Tempo de requisição esgotou (Timeout)',
            '409' => 'Conflito',
            '410' => 'Gone',
            '411' => 'comprimento necessário',
            '412' => 'Pré-condição falhou',
            '413' => 'Entidade de solicitação muito grande',
            '414' => 'Pedido-URI Too Long',
            '415' => 'Tipo de mídia não suportado',
            '416' => 'Solicitada de Faixa Não Satisfatória',
            '417' => 'Falha na expectativa',
            '422' => 'Entidade improcessável (WebDAV) (RFC 4918)',
            '423' => 'Fechado (WebDAV) (RFC 4918)',
            '424' => 'Falha de Dependência (WebDAV) (RFC 4918)',
            '425' => 'coleção não ordenada (RFC 3648)',
            '426' => 'Upgrade Obrigatório (RFC 2817)',
            '450' => 'bloqueados pelo Controle de Pais do Windows',
            '499' => 'cliente fechou Pedido (utilizado em ERPs/VPSA)',

            '500' => 'Erro interno do servidor (Internal Server Error)',
            '501' => 'Não implementado (Not implemented)',
            '502' => 'Bad Gateway',
            '503' => 'Serviço indisponível (Service Unavailable)',
            '504' => 'Gateway Time-Out'
        ];

        if(!isset($this->http_message[$code])){
            return null;
        }
        return $this->http_message[$code];
    }
}

