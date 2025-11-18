<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($title) ? esc($title) : 'LuNa Prime Imóveis' ?></title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        nav {
            background: #333;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav > div:first-child {
            font-size: 1.5em;
            font-weight: bold;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
        }
        nav a:hover {
            background: #555;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: normal;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-success {
            background: #28a745;
            color: white;
        }
        .btn-success:hover {
            background: #218838;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-warning {
            background: #ffc107;
            color: #000;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #28a745;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #dc3545;
        }
        .card {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            font-family: inherit;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
<nav>
    <div>LuNa Prime Imóveis</div>
    <div>
        <?php helper('url'); ?>
        <a href="<?= site_url('/') ?>">Início</a>
        <?php if(session()->get('logged_in')): ?>
            <a href="<?= site_url('admin/imoveis') ?>">Imóveis</a>
            <?php if(session()->get('user_tipo') === 'admin'): ?>
                <a href="<?= site_url('admin/corretor/criar') ?>">Cadastrar Corretor</a>
            <?php endif; ?>
            <a href="<?= site_url('logout') ?>">Sair (<?= esc(session()->get('user_name')) ?>)</a>
        <?php else: ?>
            <a href="<?= site_url('login') ?>">Entrar</a>
        <?php endif; ?>
    </div>
</nav>
<main style="padding: 20px;">
