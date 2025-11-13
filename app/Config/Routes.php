<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

// Rotas padrão para o controlador Home (se aplicar)
$routes->get('/', 'Imoveis::index');

// Rotas para imóveis (público e admin)
$routes->get('imoveis', 'Imoveis::index');
$routes->get('imovel/(:num)', 'Imoveis::detalhes/$1');

// Administração dos imóveis (requer autenticação)
$routes->group('admin', ['filter' => 'authAdmin'], function ($routes) {
    // Bairros (apenas admin)
    $routes->get('bairros', 'Bairros::index');
    $routes->get('bairros/create', 'Bairros::create');
    $routes->post('bairros', 'Bairros::store');
    $routes->get('bairros/edit/(:num)', 'Bairros::edit/$1');
    $routes->post('bairros/update/(:num)', 'Bairros::update/$1');
    $routes->get('bairros/delete/(:num)', 'Bairros::delete/$1');

    // Tipos de imóveis (apenas admin)
    $routes->get('tiposimoveis', 'TiposImoveis::index');
    $routes->get('tiposimoveis/create', 'TiposImoveis::create');
    $routes->post('tiposimoveis', 'TiposImoveis::store');
    $routes->get('tiposimoveis/edit/(:num)', 'TiposImoveis::edit/$1');
    $routes->post('tiposimoveis/update/(:num)', 'TiposImoveis::update/$1');
    $routes->get('tiposimoveis/delete/(:num)', 'TiposImoveis::delete/$1');

    // Cadastro de corretores (apenas admin)
    $routes->get('corretor/criar', 'Auth::criarCorretor');
    $routes->post('corretor/salvar', 'Auth::salvarCorretor');
});

// Rotas para imóveis (admin e corretor)
$routes->group('admin', ['filter' => 'authCorretor'], function ($routes) {
    // Imóveis (admin e corretor)
    $routes->get('imoveis', 'Imoveis::adminIndex');
    $routes->get('imoveis/create', 'Imoveis::create');
    $routes->post('imoveis', 'Imoveis::store');
    $routes->get('imoveis/edit/(:num)', 'Imoveis::edit/$1');
    $routes->post('imoveis/update/(:num)', 'Imoveis::update/$1');
    $routes->get('imoveis/delete/(:num)', 'Imoveis::delete/$1');
});

// Rotas para fotos (requer autenticação - admin ou corretor)
$routes->group('fotos', ['filter' => 'authCorretor'], function ($routes) {
    $routes->get('index/(:num)', 'Fotos::index/$1');
    $routes->get('create/(:num)', 'Fotos::create/$1');
    $routes->post('store', 'Fotos::store');
    $routes->get('edit/(:num)', 'Fotos::edit/$1');
    $routes->post('update/(:num)', 'Fotos::update/$1');
    $routes->get('setCapa/(:num)', 'Fotos::setCapa/$1');
    $routes->get('delete/(:num)', 'Fotos::delete/$1');
});

// Rota para servir imagens de uploads
$routes->get('uploads/(:segment)', function($filename) {
    $filepath = WRITEPATH . 'uploads/' . $filename;
    if (file_exists($filepath)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filepath);
        finfo_close($finfo);
        
        header('Content-Type: ' . $mimeType);
        readfile($filepath);
        exit;
    } else {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
});

// Rotas para autenticação
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');

$routes->set404Override(function(){
    echo view('errors/custom_404');
});

