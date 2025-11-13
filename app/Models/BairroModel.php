<?php

namespace App\Models;

use CodeIgniter\Model;

class BairroModel extends Model
{
    protected $table      = 'bairros';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'cidade', 'estado', 'cep_inicial', 'cep_final'];
    public $timestamps = false;
}
