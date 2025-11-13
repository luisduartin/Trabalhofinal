<?= view('templates/header', ['title' => 'Adicionar Bairro']) ?>

<h2>Adicionar Bairro</h2>

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

<form action="/admin/bairros" method="post">
  <label>Nome:<br />
    <input type="text" name="nome" required />
  </label><br/><br/>
  <label>Cidade:<br />
    <input type="text" name="cidade" required />
  </label><br/><br/>
  <label>Estado:<br />
    <input type="text" name="estado" maxlength="2" required />
  </label><br/><br/>
  <label>CEP Inicial:<br />
    <input type="text" name="cep_inicial" />
  </label><br/><br/>
  <label>CEP Final:<br />
    <input type="text" name="cep_final" />
  </label><br/><br/>
  <button type="submit">Salvar</button>
</form>

<?= view('templates/footer') ?>
