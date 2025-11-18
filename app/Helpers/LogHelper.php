<?php

if (!function_exists('registrar_log')) {
    /**
     * Registra uma ação no log do sistema
     * 
     * @param string $acao Ação realizada (CREATE, UPDATE, DELETE, LOGIN, LOGOUT, VIEW)
     * @param string|null $tabela Nome da tabela afetada
     * @param int|null $registro_id ID do registro afetado
     * @param array|null $dados_anteriores Dados antes da alteração (para UPDATE)
     * @param array|null $dados_novos Dados novos (para CREATE/UPDATE)
     * @param string|null $descricao Descrição adicional da ação
     * @return bool
     */
    function registrar_log(
        string $acao,
        ?string $tabela = null,
        ?int $registro_id = null,
        ?array $dados_anteriores = null,
        ?array $dados_novos = null,
        ?string $descricao = null
    ): bool {
        try {
            $logModel = new \App\Models\LogModel();
            $request = \Config\Services::request();
            
            // Obtém dados do usuário logado
            $usuario_id = session()->get('user_id');
            
            // Prepara os dados para o log
            $dados_log = [
                'usuario_id' => $usuario_id,
                'acao' => strtoupper($acao),
                'tabela' => $tabela,
                'registro_id' => $registro_id,
                'ip_address' => $request->getIPAddress(),
                'user_agent' => $request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            
            // Converte arrays para JSON se necessário
            if ($dados_anteriores !== null) {
                $dados_log['dados_anteriores'] = json_encode($dados_anteriores, JSON_UNESCAPED_UNICODE);
            }
            
            if ($dados_novos !== null) {
                $dados_log['dados_novos'] = json_encode($dados_novos, JSON_UNESCAPED_UNICODE);
            }
            
            if ($descricao !== null) {
                $dados_log['descricao'] = $descricao;
            }
            
            // Insere o log
            return $logModel->insert($dados_log) !== false;
        } catch (\Exception $e) {
            // Em caso de erro, registra no log do sistema mas não interrompe o fluxo
            log_message('error', 'Erro ao registrar log: ' . $e->getMessage());
            return false;
        }
    }
}




