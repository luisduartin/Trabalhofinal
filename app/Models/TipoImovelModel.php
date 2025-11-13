<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoImovelModel extends Model
{
    protected $table = 'tipos_imoveis';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'descricao'];

    public $timestamps = false;
}
