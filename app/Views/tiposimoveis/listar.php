<?= view('templates/header', ['title' => 'Tipos de Imóveis']) ?>

<h2>Tipos de Imóveis</h2>

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

<a href="/admin/tiposimoveis/create" style="display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 20px; font-weight: bold;">
  + Adicionar Tipo de Imóvel
</a>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 6px #ccc;">
  <thead>
    <tr style="background: #007bff; color: white;">
      <th>ID</th>
      <th>Nome</th>
      <th>Descrição</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($tipos)): ?>
      <?php foreach($tipos as $tipo): ?>
        <tr>
          <td><?= $tipo['id'] ?></td>
          <td><?= esc($tipo['nome']) ?></td>
          <td><?= esc($tipo['descricao']) ?></td>
          <td>
            <a href="/admin/tiposimoveis/edit/<?= $tipo['id'] ?>" style="color: #ffc107; text-decoration: none; margin-right: 10px;">Editar</a>
            <a href="/admin/tiposimoveis/delete/<?= $tipo['id'] ?>" 
               onclick="return confirm('Tem certeza que deseja excluir este tipo de imóvel?')" 
               style="color: #dc3545; text-decoration: none;">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="4" style="text-align: center; padding: 40px; color: #666;">
          Nenhum tipo de imóvel cadastrado.
        </td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?= view('templates/footer') ?>





