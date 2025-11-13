<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        echo view('auth/login');
    }

    public function processLogin()
    {
        $session = session();
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        $user = $model->verifyPassword($email, $senha);

        if ($user) {
            $session->set([
                'logged_in' => true,
                'user_id'   => $user['id'],
                'user_name' => $user['nome'],
                'user_email'=> $user['email'],
                'user_tipo' => $user['tipo'],
            ]);

            // Redireciona conforme o tipo de usuário
            helper('url');
            helper('log');
            registrar_log('LOGIN');
            return redirect()->to(site_url('admin/imoveis'))->with('success', 'Login realizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Email ou senha inválidos.');
        }
    }

    public function logout()
    {
        $session = session();
        helper('url');
        helper('log');
        registrar_log('LOGOUT');
        $session->destroy();
        return redirect()->to(site_url('login'))->with('success', 'Logout realizado com sucesso!');
    }

    // Cadastro de corretores (apenas admin)
    public function criarCorretor()
    {
        // Verifica se é admin
        if (session()->get('user_tipo') !== 'admin') {
            return redirect()->to(site_url('admin/imoveis'))->with('error', 'Acesso negado.');
        }
        
        echo view('auth/criar_corretor');
    }

    public function salvarCorretor()
    {
        // Verifica se é admin
        if (session()->get('user_tipo') !== 'admin') {
            return redirect()->to(site_url('admin/imoveis'))->with('error', 'Acesso negado.');
        }

        $model = new UsuarioModel();
        helper('url');
        helper('log');

        $data = [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
            'senha' => $this->request->getPost('senha'),
            'tipo'  => 'corretor', // Sempre cria como corretor
        ];

        // Validação básica
        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            return redirect()->back()->with('error', 'Todos os campos são obrigatórios.')->withInput();
        }

        // Verifica se email já existe
        $usuarioExistente = $model->where('email', $data['email'])->first();
        if ($usuarioExistente) {
            return redirect()->back()->with('error', 'Este email já está cadastrado.')->withInput();
        }

        $id = $model->insert($data);
        registrar_log('CREATE');
        return redirect()->to(site_url('admin/corretor/criar'))->with('success', 'Corretor cadastrado com sucesso!');
    }
}