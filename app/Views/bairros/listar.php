<?= view('templates/header', ['title' => 'Bairros']) ?>

<h2>Bairros</h2>

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

<a href="/admin/bairros/create">Adicionar Bairro</a>

<table border="1" cellpadding="6" cellspacing="0" style="margin-top: 15px; width: 100%;">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Cidade</th>
      <th>Estado</th>
      <th>CEP Inicial</th>
      <th>CEP Final</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($bairros)): ?>
      <?php foreach($bairros as $bairro): ?>
        <tr>
          <td><?= $bairro['id'] ?></td>
          <td><?= esc($bairro['nome']) ?></td>
          <td><?= esc($bairro['cidade']) ?></td>
          <td><?= esc($bairro['estado']) ?></td>
          <td><?= esc($bairro['cep_inicial']) ?></td>
          <td><?= esc($bairro['cep_final']) ?></td>
          <td>
            <a href="/admin/bairros/edit/<?= $bairro['id'] ?>">Editar</a> |
            <a href="/admin/bairros/delete/<?= $bairro['id'] ?>" onclick="return confirm('Confirma exclusão?')">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="7">Nenhum bairro cadastrado.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<?= view('templates/footer') ?>
