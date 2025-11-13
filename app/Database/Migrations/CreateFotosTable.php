<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFotosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'imovel_id'   => ['type' => 'INT'],
            'nome_arquivo' => ['type' => 'VARCHAR', 'constraint' => 255],
            'caminho'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'capa'        => ['type' => 'BOOLEAN', 'default' => false],
            'ordem'       => ['type' => 'INT', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('fotos_imoveis');
    }

    public function down()
    {
        $this->forge->dropTable('fotos_imoveis');
    }
}
