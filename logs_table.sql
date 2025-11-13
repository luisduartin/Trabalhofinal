-- ============================================
-- Script SQL para criar a tabela de logs
-- Sistema de Auditoria - Projeto Final
-- ============================================

CREATE TABLE IF NOT EXISTS `logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NULL DEFAULT NULL COMMENT 'ID do usuário que realizou a ação',
  `acao` VARCHAR(50) NOT NULL COMMENT 'Tipo de ação: CREATE, UPDATE, DELETE, LOGIN, LOGOUT, VIEW',
  `created_at` DATETIME NULL DEFAULT NULL COMMENT 'Data e hora da ação',
  PRIMARY KEY (`id`),
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_acao` (`acao`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabela de log de ações do sistema';

-- ============================================
-- Exemplos de uso:
-- ============================================
-- 
-- Consultar todos os logs:
-- SELECT * FROM logs ORDER BY created_at DESC;
--
-- Consultar logs de um usuário específico:
-- SELECT * FROM logs WHERE usuario_id = 1 ORDER BY created_at DESC;
--
-- Consultar logs de uma tabela específica:
-- SELECT * FROM logs WHERE tabela = 'imoveis' ORDER BY created_at DESC;
--
-- Consultar logs de uma ação específica:
-- SELECT * FROM logs WHERE acao = 'DELETE' ORDER BY created_at DESC;
--
-- Consultar logs de um período:
-- SELECT * FROM logs WHERE created_at BETWEEN '2024-01-01' AND '2024-12-31' ORDER BY created_at DESC;
--
-- ============================================

