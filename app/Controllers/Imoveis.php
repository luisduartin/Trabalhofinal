<?php

namespace App\Controllers;

use App\Models\ImovelModel;
use App\Models\BairroModel;
use App\Models\TipoImovelModel;
use App\Models\FotoModel;
use CodeIgniter\Controller;

class Imoveis extends Controller
{
    protected $model;
    protected $bairroModel;
    protected $tipoModel;
    protected $fotoModel;

    public function __construct()
    {
        $this->model = new ImovelModel();
        $this->bairroModel = new BairroModel();
        $this->tipoModel = new TipoImovelModel();
        $this->fotoModel = new FotoModel();
        helper('form');
        helper('url');
    }

    // Listagem pública com filtros
    public function index()
    {
        try {
            $filtroBairro = $this->request->getGet('bairro');
            $filtroTipo = $this->request->getGet('tipo');
            $filtroFinalidade = $this->request->getGet('finalidade');

            $dados['imoveis'] = $this->model->getImoveisComDetalhes($filtroBairro, $filtroTipo, $filtroFinalidade) ?? [];
            $dados['bairros'] = $this->bairroModel->findAll() ?? [];
            $dados['tipos'] = $this->tipoModel->findAll() ?? [];
            $dados['filtroBairro'] = $filtroBairro ?? null;
            $dados['filtroTipo'] = $filtroTipo ?? null;
            $dados['filtroFinalidade'] = $filtroFinalidade ?? null;
            
            return view('imoveis/listar', $dados);
        } catch (\Exception $e) {
            log_message('error', 'Erro em Imoveis::index: ' . $e->getMessage());
            return view('errors/html/error_exception', ['message' => 'Erro ao carregar imóveis. Verifique se o banco de dados está configurado corretamente.']);
        }
    }

    // Listagem administrativa (admin vê todos, corretor vê apenas os seus)
    public function adminIndex()
    {
        $userTipo = session()->get('user_tipo');
        $userId = session()->get('user_id');

        if ($userTipo === 'admin') {
            $dados['imoveis'] = $this->model->getImoveisComDetalhes();
        } else {
            $dados['imoveis'] = $this->model->getImoveisComDetalhes(null, null, null, $userId);
        }

        echo view('imoveis/admin_listar', $dados);
    }

    public function detalhes($id)
    {
        $imovel = $this->model->getImovelComDetalhes($id);
        if (!$imovel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $dados['imovel'] = $imovel;
        $dados['fotos'] = $this->fotoModel->where('imovel_id', $id)->orderBy('ordem')->findAll();
        
        echo view('imoveis/detalhes', $dados);
    }

    public function create()
    {
        $dados['bairros'] = $this->bairroModel->findAll();
        $dados['tipos'] = $this->tipoModel->findAll();
        echo view('imoveis/criar', $dados);
    }

    public function store()
    {
        $data = [
            'titulo'         => $this->request->getPost('titulo'),
            'descricao'      => $this->request->getPost('descricao'),
            'preco_venda'    => $this->request->getPost('preco_venda'),
            'preco_aluguel'  => $this->request->getPost('preco_aluguel'),
            'finalidade'     => $this->request->getPost('finalidade'),
            'tipo_imovel_id' => $this->request->getPost('tipo_imovel_id'),
            'bairro_id'      => $this->request->getPost('bairro_id'),
            'usuario_id'     => session()->get('user_id'),
        ];
        $id = $this->model->insert($data);
        registrar_log('CREATE');
        return redirect()->to(site_url('admin/imoveis'))->with('success', 'Imóvel cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $imovel = $this->model->find($id);
        if (!$imovel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Verifica se corretor pode editar (apenas seus imóveis)
        $userTipo = session()->get('user_tipo');
        $userId = session()->get('user_id');
        
        if ($userTipo === 'corretor' && $imovel['usuario_id'] != $userId) {
            return redirect()->to(site_url('admin/imoveis'))->with('error', 'Você não tem permissão para editar este imóvel.');
        }

        $dados['imovel'] = $imovel;
        $dados['bairros'] = $this->bairroModel->findAll();
        $dados['tipos'] = $this->tipoModel->findAll();
        echo view('imoveis/editar', $dados);
    }

    public function update($id)
    {
        $imovel = $this->model->find($id);
        if (!$imovel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Verifica se corretor pode editar (apenas seus imóveis)
        $userTipo = session()->get('user_tipo');
        $userId = session()->get('user_id');
        
        if ($userTipo === 'corretor' && $imovel['usuario_id'] != $userId) {
            return redirect()->to(site_url('admin/imoveis'))->with('error', 'Você não tem permissão para editar este imóvel.');
        }

        $dados_anteriores = $imovel;
        $data = [
            'titulo'         => $this->request->getPost('titulo'),
            'descricao'      => $this->request->getPost('descricao'),
            'preco_venda'    => $this->request->getPost('preco_venda'),
            'preco_aluguel'  => $this->request->getPost('preco_aluguel'),
            'finalidade'     => $this->request->getPost('finalidade'),
            'tipo_imovel_id' => $this->request->getPost('tipo_imovel_id'),
            'bairro_id'      => $this->request->getPost('bairro_id'),
        ];
        $this->model->update($id, $data);
        registrar_log('UPDATE');
        return redirect()->to(site_url('admin/imoveis'))->with('success', 'Imóvel atualizado com sucesso.');
    }

    public function delete($id)
    {
        $imovel = $this->model->find($id);
        if (!$imovel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Verifica se corretor pode deletar (apenas seus imóveis)
        $userTipo = session()->get('user_tipo');
        $userId = session()->get('user_id');
        
        if ($userTipo === 'corretor' && $imovel['usuario_id'] != $userId) {
            return redirect()->to(site_url('admin/imoveis'))->with('error', 'Você não tem permissão para excluir este imóvel.');
        }

        $this->model->delete($id);
        registrar_log('DELETE');
        return redirect()->to(site_url('admin/imoveis'))->with('success', 'Imóvel excluído com sucesso.');
    }
}
