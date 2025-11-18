# 📚 Explicação do Código - Sistema de Imóveis

## 1. Sistema de Logs

### 1.1 Tabela de Logs (`logs`)

**O que é:**
Uma tabela no banco de dados que armazena todas as ações realizadas no sistema.

**Campos:**
- `id` - Identificador único do log (auto incremento)
- `usuario_id` - ID do usuário que realizou a ação
- `acao` - Tipo de ação (CREATE, UPDATE, DELETE, LOGIN, LOGOUT)
- `created_at` - Data e hora da ação

**Para que serve:**
Registrar todas as ações dos usuários para auditoria e rastreabilidade.

---

### 1.2 Migration (`CreateLogsTable.php`)

**O que é:**
Arquivo que cria a estrutura da tabela `logs` no banco de dados.

**O que faz:**
- Define os campos da tabela
- Cria os índices para melhorar a performance
- Executado com o comando: `php spark migrate`

**Localização:** `app/Database/Migrations/CreateLogsTable.php`

---

### 1.3 Model (`LogModel.php`)

**O que é:**
Classe que representa a tabela `logs` e permite interagir com ela.

**O que faz:**
- Define qual tabela usar (`logs`)
- Define quais campos podem ser preenchidos (`allowedFields`)
- Permite inserir, consultar e manipular dados da tabela

**Localização:** `app/Models/LogModel.php`

**Exemplo de uso:**
```php
$logModel = new LogModel();
$logModel->insert(['usuario_id' => 1, 'acao' => 'CREATE', 'created_at' => date('Y-m-d H:i:s')]);
```

---

### 1.4 Helper (`log_helper.php`)

**O que é:**
Função auxiliar que facilita o registro de logs no sistema.

**O que faz:**
- Função `registrar_log($acao)` que:
  1. Pega o ID do usuário logado da sessão
  2. Prepara os dados do log
  3. Insere o log na tabela usando o `LogModel`
  4. Retorna `true` se sucesso, `false` se erro

**Localização:** `app/Helpers/log_helper.php`

**Como usar:**
```php
registrar_log('CREATE');  // Registra uma ação de criação
registrar_log('UPDATE');  // Registra uma ação de atualização
registrar_log('DELETE');  // Registra uma ação de exclusão
registrar_log('LOGIN');   // Registra um login
registrar_log('LOGOUT');  // Registra um logout
```

**Por que usar:**
- Simplifica o código (não precisa repetir código em cada controller)
- Centraliza a lógica de registro
- Facilita manutenção

---

### 1.5 Integração nos Controllers

**Onde está:**
- `app/Controllers/Imoveis.php` - Registra CREATE, UPDATE, DELETE de imóveis
- `app/Controllers/Bairros.php` - Registra CREATE, UPDATE, DELETE de bairros
- `app/Controllers/TiposImoveis.php` - Registra CREATE, UPDATE, DELETE de tipos
- `app/Controllers/Fotos.php` - Registra CREATE, UPDATE, DELETE de fotos
- `app/Controllers/Auth.php` - Registra LOGIN e LOGOUT

**Como funciona:**
Após cada ação (criar, editar, excluir), o controller chama `registrar_log()` para registrar a ação.

**Exemplo:**
```php
// No controller Imoveis.php, método store()
$this->model->insert($data);  // Insere o imóvel
registrar_log('CREATE');       // Registra a ação no log
```

---

## 2. Estrutura do Projeto CodeIgniter

### 2.1 Organização de Pastas

```
app/
├── Config/          # Configurações (banco, rotas, autoload)
├── Controllers/     # Controladores (lógica da aplicação)
├── Models/          # Modelos (interação com banco)
├── Views/           # Views (interface HTML)
├── Database/
│   └── Migrations/  # Migrations (criação de tabelas)
└── Helpers/         # Helpers (funções auxiliares)
```

---

### 2.2 Controllers

**O que são:**
Classes que processam as requisições do usuário e coordenam a lógica da aplicação.

**Principais Controllers:**

#### `Imoveis.php`
- `index()` - Lista imóveis públicos com filtros
- `adminIndex()` - Lista imóveis para admin/corretor
- `detalhes($id)` - Mostra detalhes de um imóvel
- `create()` - Mostra formulário de cadastro
- `store()` - Salva novo imóvel (CREATE)
- `edit($id)` - Mostra formulário de edição
- `update($id)` - Atualiza imóvel (UPDATE)
- `delete($id)` - Exclui imóvel (DELETE)

#### `Auth.php`
- `login()` - Mostra tela de login
- `processLogin()` - Processa login e cria sessão
- `logout()` - Destrói sessão
- `criarCorretor()` - Mostra formulário para cadastrar corretor (apenas admin)
- `salvarCorretor()` - Salva novo corretor (apenas admin)

#### `Bairros.php`, `TiposImoveis.php`, `Fotos.php`
- CRUD completo (Create, Read, Update, Delete)

---

### 2.3 Models

**O que são:**
Classes que representam tabelas do banco e facilitam operações de banco de dados.

**Principais Models:**

#### `ImovelModel.php`
- `getImoveisComDetalhes()` - Busca imóveis com dados de bairro e tipo
- `getImovelComDetalhes($id)` - Busca um imóvel específico com detalhes
- `insert()`, `update()`, `delete()`, `find()` - Operações CRUD básicas

#### `UsuarioModel.php`
- `verifyPassword()` - Verifica email e senha no login
- `hashPassword()` - Criptografa senha antes de salvar

#### `LogModel.php`
- Gerencia a tabela de logs

---

### 2.4 Migrations

**O que são:**
Arquivos que criam/modificam a estrutura do banco de dados de forma versionada.

**Migration Principal:**
- `2025-11-17-000000_CreateInitialSchema.php` - **Migration unificada que cria TODAS as tabelas de uma vez**

**O que faz a migration principal:**
1. Cria a tabela `usuarios` e insere usuário administrador padrão
2. Cria a tabela `bairros` e insere 23 bairros pré-definidos
3. Cria a tabela `tipos_imoveis` e insere 3 tipos pré-definidos
4. Cria a tabela `imoveis`
5. Cria a tabela `fotos_imoveis`
6. Cria a tabela `logs`

**Estrutura da Migration:**
```php
class CreateInitialSchema extends Migration
{
    public function up()
    {
        $this->createUsuariosTable();      // Cria tabela + insere admin padrão
        $this->createBairrosTable();      // Cria tabela + insere 23 bairros
        $this->createTiposImoveisTable(); // Cria tabela + insere 3 tipos
        $this->createImoveisTable();      // Cria tabela de imóveis
        $this->createFotosImoveisTable(); // Cria tabela de fotos
        $this->createLogsTable();         // Cria tabela de logs
    }
}
```

**Dados Pré-definidos Inseridos:**

1. **Usuário Administrador Padrão:**
   - Email: `admin@sistema.com`
   - Senha: `123456`
   - Tipo: `admin`
   - Nome: `Administrador`
   - ⚠️ **IMPORTANTE:** A senha é criptografada com `password_hash()` antes de ser inserida

2. **23 Bairros Pré-definidos:**
   - Alvorada, Arco-íris, Bela Vista, Centro, Erica, Esperança, Fátima, Fritsch, Jaciandi, Jardim Paraguai, Kuhn, Medianeira, Morro Grosse, Pavão, Piratini, Planalto, São Jorge, Serrano, Timbará, Trentini, Vila Nova, Zona Norte, Alto Paraíso

3. **3 Tipos de Imóveis Pré-definidos:**
   - Apartamento
   - Casa
   - Terreno

**Como executar:**
```bash
# No Windows com XAMPP:
C:\xampp\php\php.exe spark migrate

# Ou se PHP estiver no PATH:
php spark migrate
```

**Como fazer rollback (desfazer):**
```bash
C:\xampp\php\php.exe spark migrate:rollback
```

**Vantagens da Migration Unificada:**
- Cria todo o banco de dados de uma vez
- Insere dados iniciais automaticamente
- Facilita setup em novos ambientes
- Garante consistência dos dados iniciais

---

### 2.5 Rotas (`Routes.php`)

**O que é:**
Define quais URLs chamam quais métodos dos controllers.

**Estrutura:**
```php
// Rota pública
$routes->get('imoveis', 'Imoveis::index');

// Rotas protegidas (apenas admin)
$routes->group('admin', ['filter' => 'authAdmin'], function ($routes) {
    $routes->get('bairros', 'Bairros::index');
    // ...
});

// Rotas protegidas (admin e corretor)
$routes->group('admin', ['filter' => 'authCorretor'], function ($routes) {
    $routes->get('imoveis', 'Imoveis::adminIndex');
    // ...
});
```

**Filtros:**
- `authAdmin` - Apenas usuários admin podem acessar
- `authCorretor` - Admin e corretores podem acessar

---

## 3. Sistema de Autenticação

### 3.1 Login (`Auth::processLogin`)

**O que faz:**
1. Recebe email e senha do formulário
2. Busca usuário no banco pelo email
3. Verifica se a senha está correta
4. Se correto:
   - Cria sessão com dados do usuário
   - Registra LOGIN no log
   - Redireciona para área administrativa
5. Se incorreto:
   - Retorna mensagem de erro

**Dados salvos na sessão:**
- `logged_in` - true
- `user_id` - ID do usuário
- `user_name` - Nome do usuário
- `user_email` - Email do usuário
- `user_tipo` - Tipo (admin ou corretor)

---

### 3.2 Filtros de Autenticação

#### `AuthAdmin.php`
**O que faz:**
- Verifica se o usuário está logado
- Verifica se o tipo é 'admin'
- Se não for admin, redireciona para login

**Usado em:**
- Rotas de bairros
- Rotas de tipos de imóveis
- Rotas de cadastro de corretores

#### `AuthCorretor.php`
**O que faz:**
- Verifica se o usuário está logado
- Verifica se o tipo é 'admin' OU 'corretor'
- Se não for nenhum dos dois, redireciona para login

**Usado em:**
- Rotas de imóveis (admin e corretor)
- Rotas de fotos

---

## 4. Regras de Acesso (Corretor)

### 4.1 Listagem (`adminIndex`)

**O que faz:**
```php
if ($userTipo === 'admin') {
    // Admin vê TODOS os imóveis
    $dados['imoveis'] = $this->model->getImoveisComDetalhes();
} else {
    // Corretor vê APENAS seus imóveis
    $dados['imoveis'] = $this->model->getImoveisComDetalhes(null, null, null, $userId);
}
```

**Como funciona:**
- Admin: vê todos os imóveis do sistema
- Corretor: vê apenas imóveis onde `usuario_id` = seu ID

---

### 4.2 Edição (`edit` e `update`)

**O que faz:**
```php
if ($userTipo === 'corretor' && $imovel['usuario_id'] != $userId) {
    return redirect()->to(site_url('admin/imoveis'))
        ->with('error', 'Você não tem permissão para editar este imóvel.');
}
```

**Como funciona:**
- Verifica se é corretor
- Verifica se o imóvel pertence a ele
- Se não pertencer, bloqueia e mostra erro

---

### 4.3 Exclusão (`delete`)

**O que faz:**
Mesma lógica da edição - corretor só pode excluir seus próprios imóveis.

---

### 4.4 Criação (`store`)

**O que faz:**
```php
'usuario_id' => session()->get('user_id')
```

**Como funciona:**
- Automaticamente associa o imóvel ao usuário que está criando
- Corretor sempre cria imóveis para si mesmo

---

## 5. Fluxo de uma Ação (Exemplo: Criar Imóvel)

1. **Usuário acessa:** `/admin/imoveis/create`
2. **Rota:** Verifica se está autenticado (filtro `authCorretor`)
3. **Controller:** `Imoveis::create()` busca bairros e tipos, mostra o formulário
4. **Formulário exibe:**
   - Campo de título
   - Campo de descrição
   - Campos de preço (venda e aluguel)
   - Campo de finalidade (venda/aluguel/ambos)
   - **Select de Bairro** (com 23 opções pré-definidas)
   - **Select de Tipo de Imóvel** (Apartamento, Casa, Terreno)
5. **Usuário preenche** e envia formulário
6. **Rota:** `/admin/imoveis` (POST) → `Imoveis::store()`
7. **Controller:**
   - Recebe `bairro_id` e `tipo_imovel_id` do formulário
   - Valida dados
   - Insere no banco: `$this->model->insert($data)`
   - Registra log: `registrar_log('CREATE')`
   - Redireciona com mensagem de sucesso
8. **Log é salvo** na tabela `logs` com:
   - `usuario_id` = ID do usuário logado
   - `acao` = 'CREATE'
   - `created_at` = data/hora atual

**Campos do Formulário de Criação:**
- `titulo` - Título do imóvel (obrigatório)
- `descricao` - Descrição detalhada (obrigatório)
- `preco_venda` - Preço de venda (opcional)
- `preco_aluguel` - Preço de aluguel (opcional)
- `finalidade` - Venda, Aluguel ou Ambos (obrigatório)
- `bairro_id` - ID do bairro selecionado (obrigatório)
- `tipo_imovel_id` - ID do tipo selecionado (obrigatório)
- `usuario_id` - ID do usuário logado (automático)

---

## 6. Identidade Visual e Templates

### 6.1 Nome da Empresa

**Nome:** `LuNa Prime Imóveis`

**Onde aparece:**
- Cabeçalho de navegação (todas as páginas)
- Título padrão das páginas (quando não especificado)
- Rodapé (copyright)
- Página de login

**Arquivos modificados:**
- `app/Views/templates/header.php` - Cabeçalho e título
- `app/Views/templates/footer.php` - Rodapé
- `app/Views/auth/login.php` - Título da página de login

### 6.2 Estrutura de Templates

**Header (`templates/header.php`):**
- Define estilos CSS globais
- Cria barra de navegação com nome da empresa
- Menu de navegação dinâmico (muda conforme usuário logado)
- Links: Início, Imóveis, Cadastrar Corretor (apenas admin), Sair/Entrar

**Footer (`templates/footer.php`):**
- Rodapé com copyright
- Mostra ano atual dinamicamente
- Nome da empresa: "LuNa Prime Imóveis"

**Como usar:**
```php
<?= view('templates/header', ['title' => 'Título da Página']) ?>
// Conteúdo da página
<?= view('templates/footer') ?>
```

---

## 7. Como o Helper é Carregado

**No arquivo:** `app/Config/Autoload.php`

```php
public $helpers = ['log'];
```

**O que faz:**
- Carrega automaticamente o helper `log_helper.php`
- Permite usar `registrar_log()` em qualquer controller sem precisar fazer `helper('log')`

---

## 8. Formulário de Criação de Imóveis

### 8.1 Campos do Formulário

**Localização:** `app/Views/imoveis/criar.php`

**Campos disponíveis:**

1. **Título do Imóvel** (obrigatório)
   - Campo de texto livre
   - Exemplo: "Casa espaçosa com 3 quartos"

2. **Descrição** (obrigatório)
   - Campo de texto longo (textarea)
   - Descrição detalhada do imóvel

3. **Preço de Venda** (opcional)
   - Campo numérico com decimais
   - Formato: R$ 0.00

4. **Preço de Aluguel** (opcional)
   - Campo numérico com decimais
   - Formato: R$ 0.00

5. **Finalidade** (obrigatório)
   - Select com opções:
     - Venda
     - Aluguel
     - Venda e Aluguel

6. **Tipo de Imóvel** (obrigatório)
   - Select com tipos pré-definidos:
     - Apartamento
     - Casa
     - Terreno
   - Dados carregados do banco (tabela `tipos_imoveis`)

7. **Bairro** (obrigatório)
   - Select com 23 bairros pré-definidos
   - Dados carregados do banco (tabela `bairros`)
   - Lista completa: Alvorada, Arco-íris, Bela Vista, Centro, Erica, Esperança, Fátima, Fritsch, Jaciandi, Jardim Paraguai, Kuhn, Medianeira, Morro Grosse, Pavão, Piratini, Planalto, São Jorge, Serrano, Timbará, Trentini, Vila Nova, Zona Norte, Alto Paraíso

### 8.2 Como os Dados são Carregados

**No Controller (`Imoveis::create()`):**
```php
// Busca todos os bairros
$dados['bairros'] = $this->bairroModel->findAll();

// Busca todos os tipos de imóveis
$dados['tipos'] = $this->tipoModel->findAll();

// Passa para a view
echo view('imoveis/criar', $dados);
```

**Na View:**
```php
<select name="bairro_id" required>
    <option value="">Selecione...</option>
    <?php foreach($bairros as $bairro): ?>
        <option value="<?= $bairro['id'] ?>"><?= esc($bairro['nome']) ?></option>
    <?php endforeach; ?>
</select>
```

### 8.3 Validação

- Campos obrigatórios: título, descrição, finalidade, bairro_id, tipo_imovel_id
- Campos opcionais: preco_venda, preco_aluguel
- `usuario_id` é preenchido automaticamente com o ID do usuário logado

---

## 9. Resumo das Funcionalidades

### ✅ Login e Autenticação
- **Onde:** `Auth.php`
- **Como:** Verifica email/senha, cria sessão, registra LOGIN

### ✅ Regras de Acesso
- **Onde:** `Imoveis.php` (métodos edit, update, delete, adminIndex)
- **Como:** Verifica se corretor pode manipular o imóvel (verifica `usuario_id`)

### ✅ Tabela de Logs
- **Onde:** Tabela `logs` no banco
- **Como:** Migration cria, Model acessa, Helper registra, Controllers chamam

---

## 10. Perguntas que o Professor Pode Fazer

### "Como funciona o sistema de logs?"
- Tabela `logs` armazena ações
- Helper `registrar_log()` facilita o registro
- Controllers chamam após cada ação
- Registra: usuário, ação, data/hora

### "Como o corretor só vê seus imóveis?"
- No `adminIndex()` verifica o tipo de usuário
- Se corretor, filtra por `usuario_id`
- Se admin, mostra todos

### "Como funciona a autenticação?"
- `Auth::processLogin()` verifica credenciais
- Cria sessão com dados do usuário
- Filtros (`authAdmin`, `authCorretor`) protegem rotas

### "O que é uma Migration?"
- Arquivo que cria/modifica estrutura do banco
- Versiona mudanças no banco
- Executado com `php spark migrate`

### "O que é um Helper?"
- Função auxiliar reutilizável
- Simplifica código repetitivo
- `registrar_log()` é um helper

### "O que é um Model?"
- Classe que representa uma tabela
- Facilita operações de banco (insert, update, delete, find)
- Exemplo: `LogModel` representa tabela `logs`

---

## 11. Arquivos Importantes do Sistema de Logs

1. **Migration Principal:** `app/Database/Migrations/2025-11-17-000000_CreateInitialSchema.php`
   - Cria TODAS as tabelas do sistema, incluindo `logs`
   - Método `createLogsTable()` cria a estrutura da tabela de logs

2. **Model:** `app/Models/LogModel.php`
   - Interage com a tabela logs
   - Permite inserir, consultar e manipular logs

3. **Helper:** `app/Helpers/log_helper.php`
   - Função `registrar_log($acao)`
   - Simplifica o registro de logs

4. **Autoload:** `app/Config/Autoload.php`
   - Carrega o helper automaticamente
   - Permite usar `registrar_log()` sem chamar `helper('log')`

5. **Controllers:** Todos os controllers
   - Chamam `registrar_log()` após ações importantes
   - Exemplos: `Imoveis.php`, `Auth.php`, `Bairros.php`, etc.

---

## 12. Exemplo Prático Completo

**Cenário:** Usuário cria um imóvel

1. Usuário acessa `/admin/imoveis/create`
2. Preenche formulário e envia
3. `Imoveis::store()` é chamado
4. Dados são validados
5. `$this->model->insert($data)` insere no banco
6. `registrar_log('CREATE')` é chamado:
   - Pega `user_id` da sessão
   - Prepara dados: `['usuario_id' => 1, 'acao' => 'CREATE', 'created_at' => '2024-01-15 10:30:00']`
   - `LogModel->insert()` salva na tabela `logs`
7. Redireciona com mensagem de sucesso
8. Log fica registrado na tabela `logs`

---

## 13. Consultas Úteis no Banco

```sql
-- Ver todos os logs
SELECT * FROM logs ORDER BY created_at DESC;

-- Ver logs de um usuário
SELECT * FROM logs WHERE usuario_id = 1;

-- Ver logs de uma ação específica
SELECT * FROM logs WHERE acao = 'DELETE';

-- Ver quantas ações cada usuário fez
SELECT usuario_id, acao, COUNT(*) as total 
FROM logs 
GROUP BY usuario_id, acao;
```

---

## 14. Diferenças entre Admin e Corretor

| Funcionalidade | Admin | Corretor |
|----------------|-------|----------|
| Ver imóveis | Todos | Apenas os seus |
| Criar imóvel | Sim | Sim (sempre para si) |
| Editar imóvel | Qualquer | Apenas os seus |
| Excluir imóvel | Qualquer | Apenas os seus |
| Gerenciar bairros | Sim | Não |
| Gerenciar tipos | Sim | Não |
| Cadastrar corretores | Sim | Não |

---

## 15. Estrutura de Dados do Log

**Exemplo de registro na tabela `logs`:**

| id | usuario_id | acao   | created_at          |
|----|------------|--------|---------------------|
| 1  | 1          | LOGIN  | 2024-01-15 10:00:00 |
| 2  | 1          | CREATE | 2024-01-15 10:05:00 |
| 3  | 1          | UPDATE | 2024-01-15 10:10:00 |
| 4  | 1          | LOGOUT | 2024-01-15 10:15:00 |

---

## 16. Por que Usar Helper?

**Sem helper (repetitivo):**
```php
// Em cada controller, teria que fazer:
$logModel = new LogModel();
$logModel->insert([
    'usuario_id' => session()->get('user_id'),
    'acao' => 'CREATE',
    'created_at' => date('Y-m-d H:i:s')
]);
```

**Com helper (simples):**
```php
registrar_log('CREATE');
```

**Vantagens:**
- Código mais limpo
- Menos repetição
- Fácil manutenção
- Centralizado

---

## 17. Fluxo Completo do Sistema

```
1. Usuário faz login
   → Auth::processLogin()
   → Cria sessão
   → registrar_log('LOGIN')

2. Usuário cria imóvel
   → Imoveis::store()
   → Insere no banco
   → registrar_log('CREATE')

3. Usuário edita imóvel
   → Imoveis::update()
   → Atualiza no banco
   → registrar_log('UPDATE')

4. Usuário exclui imóvel
   → Imoveis::delete()
   → Remove do banco
   → registrar_log('DELETE')

5. Usuário faz logout
   → Auth::logout()
   → Destrói sessão
   → registrar_log('LOGOUT')
```

---

## 18. Conceitos Importantes

### MVC (Model-View-Controller)
- **Model:** Acessa banco de dados (`LogModel`, `ImovelModel`)
- **View:** Interface HTML (`Views/`)
- **Controller:** Lógica da aplicação (`Controllers/`)

### Session
- Armazena dados do usuário logado
- Persiste entre requisições
- Usado para autenticação

### Filter (Filtro)
- Intercepta requisições antes do controller
- Verifica autenticação
- Protege rotas

### Migration
- Versiona estrutura do banco
- Permite recriar banco em qualquer ambiente
- Executado com `php spark migrate`

---

## 19. Respostas Rápidas para o Professor

**"O que é a tabela de logs?"**
- Tabela que armazena todas as ações dos usuários (CREATE, UPDATE, DELETE, LOGIN, LOGOUT) com usuário e data/hora.

**"Como funciona o registro de logs?"**
- Helper `registrar_log()` pega o usuário da sessão, prepara os dados e salva na tabela `logs` usando o `LogModel`.

**"Onde os logs são registrados?"**
- Em todos os controllers após ações importantes: criar, editar, excluir (Imoveis, Bairros, Tipos, Fotos) e login/logout (Auth).

**"Como o corretor só vê seus imóveis?"**
- No método `adminIndex()` do `Imoveis.php`, verifica o tipo de usuário. Se for corretor, filtra por `usuario_id`. Se for admin, mostra todos.

**"O que é uma Migration?"**
- Arquivo que cria a estrutura da tabela no banco de forma versionada. Executado com `php spark migrate`.

**"O que é um Helper?"**
- Função auxiliar reutilizável. O `log_helper.php` tem a função `registrar_log()` que simplifica o registro de logs.

**"Como funciona a autenticação?"**
- `Auth::processLogin()` verifica email/senha, cria sessão com dados do usuário. Filtros (`authAdmin`, `authCorretor`) protegem rotas verificando a sessão.

**"O que é a migration unificada?"**
- A migration `CreateInitialSchema.php` cria todas as tabelas de uma vez e insere dados iniciais (usuário admin, 23 bairros, 3 tipos de imóveis). Facilita o setup do sistema.

**"Quais dados já vêm pré-definidos?"**
- 1 usuário admin (admin@sistema.com / 123456), 23 bairros da região, e 3 tipos de imóveis (Apartamento, Casa, Terreno). Todos inseridos automaticamente na migration.

**"Como funciona o formulário de criação de imóveis?"**
- O controller busca bairros e tipos do banco, passa para a view, que exibe selects. O usuário seleciona e envia. O controller recebe os IDs (`bairro_id` e `tipo_imovel_id`) e salva no banco.

**"Onde aparece o nome 'LuNa Prime Imóveis'?"**
- No cabeçalho de navegação, no título padrão das páginas, no rodapé (copyright) e na página de login. Definido nos templates `header.php` e `footer.php`.

---

## 20. Estrutura de Arquivos do Sistema de Logs

```
app/
├── Database/
│   └── Migrations/
│       └── 2025-11-17-000000_CreateInitialSchema.php  ← Cria TODAS as tabelas (incluindo logs)
├── Models/
│   └── LogModel.php               ← Model para acessar tabela logs
├── Helpers/
│   └── log_helper.php             ← Função registrar_log()
└── Config/
    └── Autoload.php               ← Carrega o helper automaticamente
```

**Nota:** A migration principal `CreateInitialSchema.php` cria todas as tabelas de uma vez, incluindo a tabela `logs` através do método `createLogsTable()`.

---

## 21. Código SQL da Tabela

```sql
CREATE TABLE `logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NULL DEFAULT NULL,
  `acao` VARCHAR(50) NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_usuario_id` (`usuario_id`),
  INDEX `idx_acao` (`acao`),
  INDEX `idx_created_at` (`created_at`)
);
```

**Campos:**
- `id` - Identificador único (chave primária)
- `usuario_id` - ID do usuário que fez a ação (pode ser NULL se não logado)
- `acao` - Tipo de ação (CREATE, UPDATE, DELETE, LOGIN, LOGOUT)
- `created_at` - Data e hora da ação

**Índices:**
- Criados para melhorar performance nas consultas

---

## 22. Dados Iniciais do Sistema

### 22.1 Usuário Padrão

**Credenciais de Acesso:**
- **Email:** `admin@sistema.com`
- **Senha:** `123456`
- **Tipo:** `admin`
- **Nome:** `Administrador`

**Como foi criado:**
- Inserido automaticamente na migration `CreateInitialSchema`
- Senha criptografada com `password_hash('123456', PASSWORD_DEFAULT)`
- Disponível imediatamente após executar `php spark migrate`

**⚠️ Importante:**
- Este é o usuário principal do sistema
- Tem acesso total (admin)
- Pode cadastrar corretores
- Pode gerenciar bairros e tipos de imóveis

### 22.2 Bairros Pré-definidos

**Total:** 23 bairros

**Lista completa:**
1. Alvorada
2. Arco-íris
3. Bela Vista
4. Centro
5. Erica
6. Esperança
7. Fátima
8. Fritsch
9. Jaciandi
10. Jardim Paraguai
11. Kuhn
12. Medianeira
13. Morro Grosse
14. Pavão
15. Piratini
16. Planalto
17. São Jorge
18. Serrano
19. Timbará
20. Trentini
21. Vila Nova
22. Zona Norte
23. Alto Paraíso

**Como foram criados:**
- Inseridos automaticamente na migration
- Disponíveis imediatamente após executar a migration
- Não é necessário cadastrar manualmente

### 22.3 Tipos de Imóveis Pré-definidos

**Total:** 3 tipos

1. **Apartamento**
2. **Casa**
3. **Terreno**

**Como foram criados:**
- Inseridos automaticamente na migration
- Disponíveis imediatamente após executar a migration
- Não é necessário cadastrar manualmente

**Uso no formulário:**
- Aparecem como opções no select "Tipo de Imóvel"
- Obrigatório selecionar um tipo ao criar imóvel

---

## 23. Checklist para a Apresentação

✅ Entender o que é a tabela de logs
✅ Saber como funciona o helper `registrar_log()`
✅ Explicar onde os logs são registrados
✅ Entender como funciona autenticação
✅ Saber como funcionam as regras de acesso (corretor)
✅ Entender o que é Migration e a migration unificada
✅ Saber o que é Model e Helper
✅ Entender a estrutura MVC
✅ Saber explicar o fluxo de uma ação completa
✅ Conhecer os dados pré-definidos (usuário, bairros, tipos)
✅ Entender o formulário de criação de imóveis
✅ Saber sobre a identidade visual (LuNa Prime Imóveis)

---

## 24. Informações Adicionais Importantes

### 24.1 Primeiro Acesso ao Sistema

**Após executar a migration:**
1. Acesse a página de login
2. Use as credenciais padrão:
   - Email: `admin@sistema.com`
   - Senha: `123456`
3. Você terá acesso completo como administrador

### 24.2 Comandos Úteis

**Executar migration:**
```bash
C:\xampp\php\php.exe spark migrate
```

**Fazer rollback (desfazer migration):**
```bash
C:\xampp\php\php.exe spark migrate:rollback
```

**Verificar se PHP está no PATH:**
- Se não estiver, use o caminho completo: `C:\xampp\php\php.exe`
- Ou adicione `C:\xampp\php` ao PATH do Windows

### 24.3 Estrutura de Dados do Banco

**Tabelas criadas pela migration:**
1. `usuarios` - Usuários do sistema (admin e corretores)
2. `bairros` - 23 bairros pré-definidos
3. `tipos_imoveis` - 3 tipos pré-definidos (Apartamento, Casa, Terreno)
4. `imoveis` - Imóveis cadastrados
5. `fotos_imoveis` - Fotos dos imóveis
6. `logs` - Logs de ações do sistema

**Dados iniciais:**
- 1 usuário admin (admin@sistema.com)
- 23 bairros
- 3 tipos de imóveis

---

**Dica:** Pratique explicar em voz alta cada parte do sistema. Isso ajuda a fixar o conhecimento!




