<?= view('templates/header', ['title' => 'Fotos do Imóvel']) ?>

<h2>Fotos do Imóvel</h2>

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
<a href="<?= site_url('fotos/create/' . $imovel_id) ?>">Adicionar Foto</a>

<table border="1" cellpadding="6" cellspacing="0" style="margin-top: 15px; width: 100%;">
  <thead>
    <tr>
      <th>Foto</th>
      <th>Capa</th>
      <th>Ordem</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($fotos)): ?>
      <?php foreach($fotos as $foto): ?>
        <tr>
          <td><img src="<?= base_url('uploads/' . $foto['nome_arquivo']) ?>" style="max-width:100px;" alt="Foto do imóvel"></td>
          <td><?= $foto['capa'] ? 'Sim' : 'Não' ?></td>
          <td><?= esc($foto['ordem']) ?></td>
          <td>
            <?php if(!$foto['capa']): ?>
              <a href="<?= site_url('fotos/setCapa/' . $foto['id']) ?>">Definir como capa</a> |
            <?php endif; ?>
            <a href="<?= site_url('fotos/delete/' . $foto['id']) ?>" onclick="return confirm('Confirma exclusão?')">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4">Nenhuma foto cadastrada.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?= view('templates/footer') ?>
