<?php

namespace App\Controllers;

use App\Models\FotoModel;
use CodeIgniter\Controller;

class Fotos extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new FotoModel();
        helper('form');
        helper('url');
    }

    public function index($imovel_id)
    {
        $dados['imovel_id'] = $imovel_id;
        $dados['fotos'] = $this->model->where('imovel_id', $imovel_id)->orderBy('ordem')->findAll();
        echo view('fotos/listar', $dados);
    }

    public function create($imovel_id)
    {
        $dados['imovel_id'] = $imovel_id;
        echo view('fotos/criar', $dados);
    }

    public function store()
    {
        $imovel_id = $this->request->getPost('imovel_id');
        $file = $this->request->getFile('foto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);

            $ordemMax = $this->model->where('imovel_id', $imovel_id)->selectMax('ordem')->first();
            $ordem = ($ordemMax['ordem'] ?? 0) + 1;

            $data = [
                'imovel_id'    => $imovel_id,
                'nome_arquivo' => $newName,
                'caminho'      => WRITEPATH . 'uploads/' . $newName,
                'capa'         => false,
                'ordem'        => $ordem,
            ];

            $id = $this->model->insert($data);
            registrar_log('CREATE');

            return redirect()->to("/fotos/index/$imovel_id")->with('success', 'Foto enviada com sucesso.');
        }

        return redirect()->back()->with('error', 'Erro no upload da foto.');
    }

    public function edit($id)
    {
        $foto = $this->model->find($id);
        if (!$foto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $dados['foto'] = $foto;
        echo view('fotos/editar', $dados);
    }

    public function update($id)
    {
        $foto = $this->model->find($id);
        if (!$foto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'nome_arquivo' => $this->request->getPost('nome_arquivo'),
            'ordem'        => $this->request->getPost('ordem'),
        ];

        $this->model->update($id, $data);
        registrar_log('UPDATE');

        return redirect()->to("/fotos/index/" . $foto['imovel_id'])->with('success', 'Foto atualizada com sucesso.');
    }

    public function setCapa($id)
    {
        $foto = $this->model->find($id);
        if (!$foto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Reseta todas as fotos do imóvel
        $this->model->where('imovel_id', $foto['imovel_id'])->set(['capa' => false])->update();

        // Marca esta foto como capa
        $this->model->update($id, ['capa' => true]);
        registrar_log('UPDATE');

        return redirect()->to("/fotos/index/" . $foto['imovel_id'])->with('success', 'Foto definida como capa.');
    }

    public function delete($id)
    {
        $foto = $this->model->find($id);
        if (!$foto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (file_exists($foto['caminho'])) {
            unlink($foto['caminho']);
        }

        $this->model->delete($id);
        registrar_log('DELETE');

        return redirect()->to("/fotos/index/" . $foto['imovel_id'])->with('success', 'Foto excluída com sucesso.');
    }
}

