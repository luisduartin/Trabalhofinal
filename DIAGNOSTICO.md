# Diagnóstico de Problemas

## Verificações Necessárias

### 1. Banco de Dados
Certifique-se de que:
- ✅ O banco de dados está criado
- ✅ As migrations foram executadas: `php spark migrate`
- ✅ O arquivo `.env` está configurado corretamente

### 2. Verificar Erros
- Abra o console do navegador (F12) para ver erros JavaScript
- Verifique os logs em `writable/logs/`
- Verifique se há erros PHP na tela

### 3. Verificar se as Tabelas Existem
Execute no banco de dados:
```sql
SHOW TABLES;
```

Deve mostrar:
- usuarios
- bairros
- tipos_imoveis
- imoveis
- fotos_imoveis

### 4. Testar Funcionalidades Básicas
1. Acesse: `http://localhost/projetofinal/`
2. Se aparecer erro, verifique qual é
3. Tente acessar: `http://localhost/projetofinal/login`

### 5. Problemas Comuns

**Erro: "Tabela não existe"**
- Execute: `php spark migrate`

**Erro: "Connection refused"**
- Verifique o arquivo `.env` com as configurações do banco

**Página em branco**
- Verifique os logs em `writable/logs/`
- Ative o modo debug no `.env`: `CI_ENVIRONMENT = development`

**Filtros não funcionam**
- Verifique se há dados no banco
- Cadastre alguns bairros e tipos de imóveis primeiro

### 6. Criar Dados de Teste
Para testar, você precisa:
1. Criar alguns bairros (via `/admin/bairros`)
2. Criar alguns tipos de imóveis (via `/admin/tiposimoveis`)
3. Criar um usuário admin (via banco de dados ou migration/seed)
4. Criar alguns imóveis (via `/admin/imoveis`)

### 7. Verificar Permissões
- Certifique-se que a pasta `writable/` tem permissões de escrita
- Certifique-se que a pasta `writable/uploads/` existe e tem permissões de escrita




