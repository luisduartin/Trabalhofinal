<?= view('templates/header', ['title' => 'Editar Imóvel']) ?>

<div style="max-width:800px; margin:40px auto; padding: 0 20px;">
  <h1 style="font-size: 2em; margin-bottom: 30px;">Editar Imóvel</h1>

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
  <div class="card" style="padding: 40px;">
    <form action="<?= site_url('admin/imoveis/update/' . $imovel['id']) ?>" method="post" style="display: grid; gap: 25px;">
      <div>
        <label>Título do Imóvel</label>
        <input type="text" name="titulo" value="<?= esc($imovel['titulo']) ?>" required placeholder="Ex: Casa espaçosa com 3 quartos" />
      </div>

      <div>
        <label>Descrição</label>
        <textarea name="descricao" rows="6" required placeholder="Descreva as características, localização, comodidades do imóvel..."><?= esc($imovel['descricao']) ?></textarea>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div>
          <label>Preço de Venda (R$)</label>
          <input type="number" step="0.01" name="preco_venda" value="<?= esc($imovel['preco_venda']) ?>" placeholder="0.00" />
        </div>
        <div>
          <label>Preço de Aluguel (R$)</label>
          <input type="number" step="0.01" name="preco_aluguel" value="<?= esc($imovel['preco_aluguel']) ?>" placeholder="0.00" />
        </div>
      </div>

      <div>
        <label>Finalidade</label>
        <select name="finalidade" required>
          <option value="venda" <?= $imovel['finalidade'] === 'venda' ? 'selected' : '' ?>>Venda</option>
          <option value="aluguel" <?= $imovel['finalidade'] === 'aluguel' ? 'selected' : '' ?>>Aluguel</option>
          <option value="ambos" <?= $imovel['finalidade'] === 'ambos' ? 'selected' : '' ?>>Venda e Aluguel</option>
        </select>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div>
          <label>Tipo de Imóvel</label>
          <select name="tipo_imovel_id" required>
            <?php foreach ($tipos as $tipo): ?>
              <option value="<?= $tipo['id'] ?>" <?= $tipo['id'] == $imovel['tipo_imovel_id'] ? 'selected' : '' ?>><?= esc($tipo['nome']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label>Bairro</label>
          <select name="bairro_id" required>
            <?php foreach ($bairros as $bairro): ?>
              <option value="<?= $bairro['id'] ?>" <?= $bairro['id'] == $imovel['bairro_id'] ? 'selected' : '' ?>><?= esc($bairro['nome']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div style="display: flex; gap: 15px; margin-top: 10px;">
        <button type="submit" class="btn btn-primary">
          Salvar Alterações
        </button>
        <a href="<?= site_url('admin/imoveis') ?>" class="btn btn-warning">
          Cancelar
        </a>
      </div>
    </form>
  </div>
</div>

<?= view('templates/footer') ?>
