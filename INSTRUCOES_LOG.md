# 📋 Instruções para Adicionar a Tabela de Log ao Banco de Dados

Existem **duas formas** de adicionar a tabela `logs` ao seu banco de dados:

---

## 🚀 **OPÇÃO 1: Usando Migration do CodeIgniter (RECOMENDADO)**

Esta é a forma mais adequada para projetos CodeIgniter, pois mantém o controle de versão das tabelas.

### Passos:

1. **Abra o terminal/PowerShell** na pasta do projeto:
   ```bash
   cd C:\xampp\htdocs\projetofinal
   ```

2. **Execute o comando de migration:**
   ```bash
   php spark migrate
   ```

   Isso irá executar todas as migrations pendentes, incluindo a tabela `logs`.

3. **Verificar se foi criada:**
   ```bash
   php spark migrate:status
   ```

---

## 🗄️ **OPÇÃO 2: Executando SQL Diretamente no Banco**

Se preferir executar o SQL manualmente ou se a migration não funcionar:

### Passos:

1. **Abra o phpMyAdmin** (ou seu cliente MySQL preferido):
   - Acesse: `http://localhost/phpmyadmin`
   - Selecione o banco de dados do seu projeto

2. **Abra a aba "SQL"** no phpMyAdmin

3. **Copie e cole o conteúdo do arquivo `logs_table.sql`** que está na raiz do projeto

4. **Clique em "Executar"** ou pressione `Ctrl + Enter`

5. **Verificar se foi criada:**
   Execute esta query:
   ```sql
   SHOW TABLES LIKE 'logs';
   ```
   
   Ou:
   ```sql
   DESCRIBE logs;
   ```

--- php spark migrate

## ✅ **Verificação Final**

Após adicionar a tabela, verifique se ela foi criada corretamente:

### No phpMyAdmin:
```sql
SELECT * FROM logs LIMIT 10;
```

### Ou execute no terminal:
```bash
php spark db:table logs
```

---

## 📊 **Estrutura da Tabela**

A tabela `logs` terá os seguintes campos:

- `id` - ID único do log (auto incremento)
- `usuario_id` - ID do usuário que realizou a ação
- `acao` - Tipo de ação (CREATE, UPDATE, DELETE, LOGIN, LOGOUT)
- `tabela` - Nome da tabela afetada (imoveis, usuarios, bairros, etc.)
- `registro_id` - ID do registro afetado
- `dados_anteriores` - JSON com dados antes da alteração
- `dados_novos` - JSON com dados novos
- `descricao` - Descrição da ação
- `ip_address` - Endereço IP de quem realizou a ação
- `user_agent` - User Agent do navegador
- `created_at` - Data e hora da ação

---

## 🔍 **Consultas Úteis**

Após a tabela estar criada, você pode consultar os logs:

```sql
-- Ver todos os logs (mais recentes primeiro)
SELECT * FROM logs ORDER BY created_at DESC;

-- Ver logs de um usuário específico
SELECT * FROM logs WHERE usuario_id = 1 ORDER BY created_at DESC;

-- Ver logs de uma tabela específica
SELECT * FROM logs WHERE tabela = 'imoveis' ORDER BY created_at DESC;

-- Ver logs de uma ação específica
SELECT * FROM logs WHERE acao = 'DELETE' ORDER BY created_at DESC;

-- Ver logs de um período
SELECT * FROM logs 
WHERE created_at BETWEEN '2024-01-01' AND '2024-12-31' 
ORDER BY created_at DESC;
```

---

## ⚠️ **Importante**

- A tabela será criada automaticamente quando você usar o sistema (criar, editar, excluir registros)
- Todos os logs são registrados automaticamente nos controllers
- As senhas dos usuários **NÃO** são armazenadas nos logs por segurança

---

## 🆘 **Problemas?**

Se encontrar algum erro:

1. **Verifique se o banco de dados está configurado corretamente** no arquivo `.env` ou `app/Config/Database.php`
2. **Verifique se você tem permissões** para criar tabelas no banco
3. **Verifique os logs** em `writable/logs/` para ver erros detalhados

