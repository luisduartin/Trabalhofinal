<?= view('templates/header', ['title' => 'Gerenciar Imóveis']) ?>

<div style="max-width:1400px; margin:40px auto; padding: 0 20px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 20px;">
    <h1 style="margin: 0; font-size: 2em;">
      <?= session()->get('user_tipo') === 'admin' ? 'Gerenciar Imóveis' : 'Meus Imóveis' ?>
    </h1>
    <?php helper('url'); ?>
    <a href="<?= site_url('admin/imoveis/create') ?>" class="btn btn-primary">
      Adicionar Imóvel
    </a>
  </div>

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

  <div class="card" style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr style="background: #333; color: white;">
          <th style="padding: 15px; text-align: left; font-weight: 600;">ID</th>
          <th style="padding: 15px; text-align: left; font-weight: 600;">Título</th>
          <th style="padding: 15px; text-align: left; font-weight: 600;">Bairro</th>
          <th style="padding: 15px; text-align: left; font-weight: 600;">Tipo</th>
          <th style="padding: 15px; text-align: left; font-weight: 600;">Finalidade</th>
          <th style="padding: 15px; text-align: right; font-weight: 600;">Preço Venda</th>
          <th style="padding: 15px; text-align: right; font-weight: 600;">Preço Aluguel</th>
          <th style="padding: 15px; text-align: center; font-weight: 600;">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($imoveis)): ?>
          <?php foreach($imoveis as $index => $imovel): ?>
            <tr style="border-bottom: 1px solid #e0e0e0; transition: background 0.2s;" 
                onmouseover="this.style.background='#f8f9ff'" 
                onmouseout="this.style.background='white'">
              <td style="padding: 15px; color: #666;"><?= $imovel['id'] ?></td>
              <td style="padding: 15px; font-weight: 600; color: #333;"><?= esc($imovel['titulo']) ?></td>
              <td style="padding: 15px; color: #555;"><?= esc($imovel['bairro_nome']) ?></td>
              <td style="padding: 15px; color: #555;"><?= esc($imovel['tipo_nome']) ?></td>
              <td style="padding: 15px;">
                <span style="padding: 4px 12px; border-radius: 12px; font-size: 0.85em; font-weight: 600; background: #e8eaff; color: #667eea;">
                  <?= esc(ucfirst($imovel['finalidade'])) ?>
                </span>
              </td>
              <td style="padding: 15px; text-align: right; font-weight: 600; color: #28a745;">
                <?= $imovel['preco_venda'] > 0 ? 'R$ ' . number_format($imovel['preco_venda'], 2, ',', '.') : '-' ?>
              </td>
              <td style="padding: 15px; text-align: right; font-weight: 600; color: #007bff;">
                <?= $imovel['preco_aluguel'] > 0 ? 'R$ ' . number_format($imovel['preco_aluguel'], 2, ',', '.') : '-' ?>
              </td>
              <td style="padding: 15px; text-align: center;">
                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                  <a href="<?= site_url('imovel/' . $imovel['id']) ?>" 
                     class="btn btn-primary" style="padding: 6px 12px; font-size: 0.9em;">Ver</a>
                  <a href="<?= site_url('fotos/index/' . $imovel['id']) ?>" 
                     class="btn btn-success" style="padding: 6px 12px; font-size: 0.9em;">Fotos</a>
                  <a href="<?= site_url('admin/imoveis/edit/' . $imovel['id']) ?>" 
                     class="btn btn-warning" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                  <a href="<?= site_url('admin/imoveis/delete/' . $imovel['id']) ?>" 
                     onclick="return confirm('Tem certeza que deseja excluir este imóvel?')"
                     class="btn btn-danger" style="padding: 6px 12px; font-size: 0.9em;">Excluir</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" style="text-align: center; padding: 60px 20px; color: #666;">
              <p style="font-size: 1.2em; margin: 0;">Nenhum imóvel cadastrado.</p>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= view('templates/footer') ?>

