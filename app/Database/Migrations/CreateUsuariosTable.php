<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true],
            'nome'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'senha'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'tipo'      => ['type' => 'ENUM', 'constraint' => ['admin', 'corretor']],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
            'updated_at'=> ['type' => 'DATETIME', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
