<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTiposImoveisTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'auto_increment' => true],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 150],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tiposimoveis');
    }

    public function down()
    {
        $this->forge->dropTable('tiposimoveis');
    }
}
