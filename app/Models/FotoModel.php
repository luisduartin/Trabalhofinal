<?php

namespace App\Models;

use CodeIgniter\Model;

class FotoModel extends Model
{
    protected $table      = 'fotos_imoveis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['imovel_id', 'nome_arquivo', 'caminho', 'capa', 'ordem'];

    public $timestamps = false;
}
