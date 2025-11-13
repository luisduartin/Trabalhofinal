<?= view('templates/header', ['title' => 'Editar Foto']) ?>

<h2>Editar Foto</h2>

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

<?php helper('url'); ?>
<form action="<?= site_url('fotos/update/' . $foto['id']) ?>" method="post">
  <label>Nome do Arquivo:<br />
    <input type="text" name="nome_arquivo" value="<?= esc($foto['nome_arquivo']) ?>" required />
  </label><br/><br/>
  <label>Ordem:<br />
    <input type="number" name="ordem" value="<?= esc($foto['ordem']) ?>" required />
  </label><br/><br/>
  <button type="submit">Salvar Alterações</button>
</form>

<p><a href="<?= site_url('fotos/index/' . $foto['imovel_id']) ?>">← Voltar para lista de fotos</a></p>

<?= view('templates/footer') ?>
