<?= view('templates/header', ['title' => 'Imóveis Disponíveis']) ?>

<div style="max-width:1400px; margin:40px auto; padding: 0 20px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
    <h1 style="margin: 0; font-size: 2em;">Imóveis Disponíveis</h1>
    <?php if(session()->get('logged_in')): ?>
      <?php helper('url'); ?>
      <a href="<?= site_url('admin/imoveis') ?>" class="btn btn-success">
        Meus Imóveis
      </a>
    <?php endif; ?>
  </div>

  <!-- Filtros -->
  <div class="card" style="padding: 30px; margin-bottom: 40px;">
    <h3 style="margin-top: 0; margin-bottom: 20px;">Buscar Imóveis</h3>
    <?php helper('url'); ?>
    <form method="get" action="<?= site_url('imoveis') ?>" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; align-items:end;">
      <div>
        <label>Bairro</label>
        <select name="bairro">
          <option value="">Todos os bairros</option>
          <?php if(!empty($bairros)): ?>
            <?php foreach($bairros as $bairro): ?>
              <option value="<?= $bairro['id'] ?>" <?= (isset($filtroBairro) && $filtroBairro == $bairro['id']) ? 'selected' : '' ?>>
                <?= esc($bairro['nome']) ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <div>
        <label>Tipo de Imóvel</label>
        <select name="tipo">
          <option value="">Todos os tipos</option>
          <?php if(!empty($tipos)): ?>
            <?php foreach($tipos as $tipo): ?>
              <option value="<?= $tipo['id'] ?>" <?= (isset($filtroTipo) && $filtroTipo == $tipo['id']) ? 'selected' : '' ?>>
                <?= esc($tipo['nome']) ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <div>
        <label>Finalidade</label>
        <select name="finalidade">
          <option value="">Todas</option>
          <option value="venda" <?= (isset($filtroFinalidade) && $filtroFinalidade == 'venda') ? 'selected' : '' ?>>Venda</option>
          <option value="aluguel" <?= (isset($filtroFinalidade) && $filtroFinalidade == 'aluguel') ? 'selected' : '' ?>>Aluguel</option>
          <option value="ambos" <?= (isset($filtroFinalidade) && $filtroFinalidade == 'ambos') ? 'selected' : '' ?>>Ambos</option>
        </select>
      </div>
      <div>
        <button type="submit" class="btn btn-primary" style="width:100%;">
          Filtrar
        </button>
      </div>
    </form>
  </div>

  <!-- Listagem de imóveis -->
  <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:25px;">
    <?php if(!empty($imoveis)): ?>
      <?php foreach($imoveis as $imovel): ?>
        <div class="card">
          <!-- Foto de Capa -->
          <?php if(!empty($imovel['foto_capa'])): ?>
            <div style="width:100%; height:220px; overflow:hidden; background:#ddd; position:relative;">
              <img src="<?= base_url('uploads/' . $imovel['foto_capa']) ?>" 
                   alt="<?= esc($imovel['titulo']) ?>" 
                   style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>
          <?php else: ?>
            <div style="width:100%; height:220px; background:#ddd; display:flex; align-items:center; justify-content:center; color:#666;">
              Sem foto
            </div>
          <?php endif; ?>
          
          <!-- Conteúdo do Card -->
          <div style="padding:20px; display:flex; flex-direction:column; flex-grow:1;">
            <h3 style="margin:0 0 10px 0; font-size:1.3em; color:#333; line-height:1.3;"><?= esc($imovel['titulo']) ?></h3>
            <div style="color:#666; font-size:0.9em; margin-bottom:12px;">
              <?= esc($imovel['bairro_nome']) ?> | <?= esc($imovel['tipo_nome']) ?>
            </div>
            <div style="margin-bottom:15px; color:#666; font-size:0.95em; flex-grow:1; line-height:1.6;">
              <?= strlen($imovel['descricao']) > 120 ? esc(substr($imovel['descricao'], 0, 120)) . '...' : esc($imovel['descricao']) ?>
            </div>
            <div style="font-weight:bold; font-size:1.2em; color:#333; margin-bottom:15px; padding:10px; background:#f8f9fa; border-radius:4px;">
              <?php if($imovel['preco_venda'] > 0): ?>
                <div style="margin-bottom:5px;">Venda: R$ <?= number_format($imovel['preco_venda'],2,',','.') ?></div>
              <?php endif; ?>
              <?php if($imovel['preco_aluguel'] > 0): ?>
                <div>Aluguel: R$ <?= number_format($imovel['preco_aluguel'],2,',','.') ?></div>
              <?php endif; ?>
            </div>
            <a href="<?= site_url('imovel/' . $imovel['id']) ?>" class="btn btn-primary" style="text-align:center; margin-top:auto;">
              Ver Detalhes
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="card" style="grid-column:1/-1; text-align:center; padding:60px 20px;">
        <p style="font-size:1.2em; color:#666; margin:0;">Nenhum imóvel encontrado com os filtros selecionados.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<?= view('templates/footer') ?>
