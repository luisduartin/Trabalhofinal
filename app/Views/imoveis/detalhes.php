<?= view('templates/header', ['title' => $imovel['titulo']]) ?>

<div style="max-width: 1100px; margin: 40px auto; padding: 0 20px;">
  <div class="card" style="overflow: hidden;">
    <!-- Header com título e informações -->
    <div style="background: #333; padding: 30px; color: white;">
      <h1 style="margin: 0 0 15px 0; font-size: 2em; font-weight: bold;"><?= esc($imovel['titulo']) ?></h1>
      <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 1em;">
        <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 4px;"><?= esc($imovel['bairro_nome']) ?></span>
        <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 4px;"><?= esc($imovel['tipo_nome']) ?></span>
      </div>
    </div>

    <div style="padding: 30px;">
      <!-- Fotos do Imóvel -->
      <?php if(!empty($fotos)): ?>
        <div style="margin-bottom: 40px;">
          <h2 style="margin-bottom: 20px; color: #333; font-size: 1.5em; border-bottom: 2px solid #ddd; padding-bottom: 10px;">Galeria de Fotos</h2>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <?php foreach($fotos as $foto): ?>
              <div class="card" style="overflow: hidden; position: relative;">
                <?php 
                  helper('url');
                  $caminhoFoto = base_url('uploads/' . $foto['nome_arquivo']);
                ?>
                <img src="<?= $caminhoFoto ?>" 
                     alt="Foto do imóvel" 
                     style="width: 100%; height: 250px; object-fit: cover; display: block;">
                <?php if($foto['capa']): ?>
                  <div style="position: absolute; top: 10px; right: 10px; background: #28a745; color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.85em; font-weight: bold;">
                    Capa
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php else: ?>
        <div class="card" style="text-align: center; padding: 40px; margin-bottom: 30px; background: #f8f9fa;">
          <p style="color: #666; margin: 0; font-size: 1.1em;">Nenhuma foto cadastrada para este imóvel.</p>
        </div>
      <?php endif; ?>
      
      <!-- Descrição -->
      <div style="margin-bottom: 30px;">
        <h2 style="margin-bottom: 15px; color: #333; font-size: 1.5em; border-bottom: 2px solid #ddd; padding-bottom: 10px;">Descrição</h2>
        <div style="white-space: pre-wrap; line-height: 1.8; color: #555; font-size: 1.05em; padding: 20px; background: #f8f9fa; border-radius: 8px;">
          <?= nl2br(esc($imovel['descricao'])) ?>
        </div>
      </div>
      
      <!-- Preços -->
      <div class="card" style="background: #f8f9fa; padding: 25px; margin-bottom: 30px; border: 1px solid #ddd;">
        <h2 style="margin-top: 0; margin-bottom: 20px; color: #333; font-size: 1.5em;">Valores</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
          <?php if ($imovel['preco_venda'] > 0): ?>
            <div style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
              <div style="font-size: 0.9em; color: #666; margin-bottom: 8px;">VENDA</div>
              <div style="font-weight: bold; font-size: 1.8em; color: #333;">R$ <?= number_format($imovel['preco_venda'], 2, ',', '.') ?></div>
            </div>
          <?php endif; ?>
          <?php if ($imovel['preco_aluguel'] > 0): ?>
            <div style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
              <div style="font-size: 0.9em; color: #666; margin-bottom: 8px;">ALUGUEL</div>
              <div style="font-weight: bold; font-size: 1.8em; color: #333;">R$ <?= number_format($imovel['preco_aluguel'], 2, ',', '.') ?></div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      
      <?php helper('url'); ?>
      <a href="<?= site_url('/') ?>" class="btn btn-primary">
        ← Voltar para Lista
      </a>
    </div>
  </div>
</div>

<?= view('templates/footer') ?>
