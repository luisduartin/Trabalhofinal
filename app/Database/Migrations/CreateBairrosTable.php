<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBairrosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'auto_increment' => true],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 150],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bairros');
    }

    public function down()
    {
        $this->forge->dropTable('bairros');
    }
}
