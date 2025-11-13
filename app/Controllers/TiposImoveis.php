<?php

namespace App\Controllers;

use App\Models\TipoImovelModel;
use CodeIgniter\Controller;

class TiposImoveis extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new TipoImovelModel();
        helper('form');
        helper('url');
    }

    public function index()
    {
        $dados['tipos'] = $this->model->findAll();
        echo view('tiposimoveis/listar', $dados);
    }

    public function create()
    {
        echo view('tiposimoveis/criar');
    }

    public function store()
    {
        $data = [
            'nome' => $this->request->getPost('nome'),
            'descricao' => $this->request->getPost('descricao'),
        ];
        $id = $this->model->insert($data);
        registrar_log('CREATE');
        return redirect()->to('/admin/tiposimoveis')->with('success', 'Tipo de imóvel cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $tipo = $this->model->find($id);
        if (!$tipo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $dados['tipo'] = $tipo;
        echo view('tiposimoveis/editar', $dados);
    }

    public function update($id)
    {
        $data = [
            'nome' => $this->request->getPost('nome'),
            'descricao' => $this->request->getPost('descricao'),
        ];
        $this->model->update($id, $data);
        registrar_log('UPDATE');
        return redirect()->to('/admin/tiposimoveis')->with('success', 'Tipo de imóvel atualizado com sucesso.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        registrar_log('DELETE');
        return redirect()->to('/admin/tiposimoveis')->with('success', 'Tipo de imóvel excluído com sucesso.');
    }
}
