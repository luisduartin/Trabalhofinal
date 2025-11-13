<?php

if (!function_exists('registrar_log')) {
    /**
     * Registra uma ação no log do sistema
     * 
     * @param string $acao Ação realizada (CREATE, UPDATE, DELETE, LOGIN, LOGOUT, VIEW)
     * @return bool
     */
    function registrar_log(string $acao): bool {
        try {
            $logModel = new \App\Models\LogModel();
            
            // Obtém dados do usuário logado
            $usuario_id = session()->get('user_id');
            
            // Prepara os dados para o log
            $dados_log = [
                'usuario_id' => $usuario_id,
                'acao' => strtoupper($acao),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            
            // Insere o log
            return $logModel->insert($dados_log) !== false;
        } catch (\Exception $e) {
            // Em caso de erro, registra no log do sistema mas não interrompe o fluxo
            log_message('error', 'Erro ao registrar log: ' . $e->getMessage());
            return false;
        }
    }
}

