<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Sistema Imóveis</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: #f5f5f5;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container { 
            max-width: 400px; 
            width: 100%;
            background: white; 
            padding: 30px; 
            border-radius: 4px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
            font-size: 1.8em;
        }
        input[type="email"], input[type="password"] {
            width: 100%; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
            font-size: 1em;
            font-family: inherit;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #007bff;
        }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #007bff;
            border: none; 
            color: white; 
            font-size: 1em; 
            border-radius: 4px; 
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover { 
            background: #0056b3;
        }
        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #dc3545;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #28a745;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php helper('url'); ?>
    <form action="<?= site_url('login') ?>" method="post">
        <input type="email" name="email" placeholder="Email" required autofocus />
        <input type="password" name="senha" placeholder="Senha" required />
        <button type="submit">Entrar</button>
    </form>
    <div class="back-link">
        <a href="<?= site_url('/') ?>">← Voltar para página inicial</a>
    </div>
</div>

</body>
</html>
