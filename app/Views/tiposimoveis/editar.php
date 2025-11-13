<?= view('templates/header', ['title' => 'Editar Tipo de Imóvel']) ?>

<h2>Editar Tipo de Imóvel</h2>

<?php if(session()->getFlashdata('success')): ?>
  <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
  <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<form action="/admin/tiposimoveis/update/<?= $tipo['id'] ?>" method="post">
  <label>Nome:<br />
    <input type="text" name="nome" value="<?= esc($tipo['nome']) ?>" required />
  </label><br/><br/>
  <label>Descrição:<br />
    <textarea name="descricao"><?= esc($tipo['descricao']) ?></textarea>
  </label><br/><br/>
  <button type="submit">Salvar</button>
</form>

<?= view('templates/footer') ?>
