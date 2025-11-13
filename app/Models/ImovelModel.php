<?php

namespace App\Models;

use CodeIgniter\Model;

class ImovelModel extends Model
{
    protected $table      = 'imoveis';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'titulo', 'descricao', 'preco_venda', 'preco_aluguel', 'finalidade',
        'tipo_imovel_id', 'bairro_id', 'usuario_id'
    ];

    public function getImoveisComDetalhes($filtroBairro = null, $filtroTipo = null, $filtroFinalidade = null, $usuarioId = null)
    {
        $query = $this->select('imoveis.*, bairros.nome as bairro_nome, tipos_imoveis.nome as tipo_nome')
            ->join('bairros', 'bairros.id = imoveis.bairro_id')
            ->join('tipos_imoveis', 'tipos_imoveis.id = imoveis.tipo_imovel_id');

        // Filtro por bairro
        if ($filtroBairro) {
            $query->where('imoveis.bairro_id', $filtroBairro);
        }

        // Filtro por tipo
        if ($filtroTipo) {
            $query->where('imoveis.tipo_imovel_id', $filtroTipo);
        }

        // Filtro por finalidade
        if ($filtroFinalidade) {
            if ($filtroFinalidade === 'venda') {
                $query->where('imoveis.preco_venda >', 0);
            } elseif ($filtroFinalidade === 'aluguel') {
                $query->where('imoveis.preco_aluguel >', 0);
            } elseif ($filtroFinalidade === 'ambos') {
                $query->where('imoveis.finalidade', 'ambos');
            }
        }

        // Filtro por usuário (para corretor ver apenas seus imóveis)
        if ($usuarioId) {
            $query->where('imoveis.usuario_id', $usuarioId);
        }

        $resultado = $query->findAll();
        
        // Busca a foto de capa para cada imóvel
        $db = \Config\Database::connect();
        foreach ($resultado as &$imovel) {
            // Busca a foto de capa (marcada como capa = 1)
            $fotoCapa = $db->table('fotos_imoveis')
                ->where('imovel_id', $imovel['id'])
                ->where('capa', 1)
                ->get()
                ->getRowArray();
            
            // Se não tem capa definida, pega a primeira foto
            if (!$fotoCapa) {
                $fotoCapa = $db->table('fotos_imoveis')
                    ->where('imovel_id', $imovel['id'])
                    ->orderBy('ordem', 'ASC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();
            }
            
            $imovel['foto_capa'] = $fotoCapa ? $fotoCapa['nome_arquivo'] : null;
        }
        
        return $resultado;
    }

    public function getImovelComDetalhes($id)
    {
        return $this->select('imoveis.*, bairros.nome as bairro_nome, tipos_imoveis.nome as tipo_nome')
            ->join('bairros', 'bairros.id = imoveis.bairro_id')
            ->join('tipos_imoveis', 'tipos_imoveis.id = imoveis.tipo_imovel_id')
            ->where('imoveis.id', $id)
            ->first();
    }
}
