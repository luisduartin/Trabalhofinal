<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página Não Encontrada</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 40px; text-align: center; }
        h1 { font-size: 4em; color: #007bff; }
        p { font-size: 1.5em; }
        a { color: #007bff; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>A página que você está procurando não foi encontrada.</p>
    <?php helper('url'); ?>
    <p><a href="<?= site_url('/') ?>">Voltar para a página inicial</a></p>
</body>
</html>
