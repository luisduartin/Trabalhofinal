<?= view('templates/header', ['title' => 'Adicionar Foto']) ?>

<h2>Adicionar Foto</h2>

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
<form action="<?= site_url('fotos/store') ?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="imovel_id" value="<?= $imovel_id ?>" />
  <label>Escolha a foto para upload:<br />
    <input type="file" name="foto" accept="image/*" required />
  </label><br/><br/>
  <button type="submit">Enviar</button>
</form>

<p><a href="<?= site_url('fotos/index/' . $imovel_id) ?>">← Voltar para lista de fotos</a></p>

<?= view('templates/footer') ?>
