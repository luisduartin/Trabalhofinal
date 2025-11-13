<?php

namespace App\Controllers;

use App\Models\BairroModel;
use CodeIgniter\Controller;

class Bairros extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new BairroModel();
        helper('form');
        helper('url');
    }

    public function index()
    {
        $dados['bairros'] = $this->model->findAll();
        echo view('bairros/listar', $dados);
    }

    public function create()
    {
        echo view('bairros/criar');
    }

    public function store()
    {
        $data = [
            'nome'      => $this->request->getPost('nome'),
            'cidade'    => $this->request->getPost('cidade'),
            'estado'    => $this->request->getPost('estado'),
            'cep_inicial' => $this->request->getPost('cep_inicial'),
            'cep_final' => $this->request->getPost('cep_final'),
        ];
        $id = $this->model->insert($data);
        registrar_log('CREATE');
        return redirect()->to('/admin/bairros')->with('success', 'Bairro cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $bairro = $this->model->find($id);
        if (!$bairro) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $dados['bairro'] = $bairro;
        echo view('bairros/editar', $dados);
    }

    public function update($id)
    {
        $data = [
            'nome'      => $this->request->getPost('nome'),
            'cidade'    => $this->request->getPost('cidade'),
            'estado'    => $this->request->getPost('estado'),
            'cep_inicial' => $this->request->getPost('cep_inicial'),
            'cep_final' => $this->request->getPost('cep_final'),
        ];
        $this->model->update($id, $data);
        registrar_log('UPDATE');
        return redirect()->to('/admin/bairros')->with('success', 'Bairro atualizado com sucesso.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        registrar_log('DELETE');
        return redirect()->to('/admin/bairros')->with('success', 'Bairro excluído com sucesso.');
    }
}
