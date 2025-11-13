<?= view('templates/header', ['title' => 'Cadastrar Corretor']) ?>

<div style="max-width:600px; margin:40px auto; padding: 0 20px;">
  <h1 style="font-size: 2em; margin-bottom: 30px;">Cadastrar Corretor</h1>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-error">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <?php helper('url'); ?>
  <div class="card" style="padding: 30px;">
    <form action="<?= site_url('admin/corretor/salvar') ?>" method="post" style="display: grid; gap: 20px;">
      <div>
        <label>Nome Completo</label>
        <input type="text" name="nome" value="<?= old('nome') ?>" required placeholder="Ex: João Silva" />
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required placeholder="Ex: joao@exemplo.com" />
      </div>

      <div>
        <label>Senha</label>
        <input type="password" name="senha" required placeholder="Digite uma senha" />
      </div>

      <div style="display: flex; gap: 15px; margin-top: 10px;">
        <button type="submit" class="btn btn-primary" style="flex: 1;">
          Cadastrar
        </button>
        <a href="<?= site_url('admin/imoveis') ?>" class="btn btn-warning" style="flex: 1; text-align: center;">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>

<?= view('templates/footer') ?>

