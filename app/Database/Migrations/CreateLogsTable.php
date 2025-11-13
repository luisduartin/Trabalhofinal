<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'usuario_id'    => ['type' => 'INT', 'null' => true],
            'acao'          => ['type' => 'VARCHAR', 'constraint' => 50], // CREATE, UPDATE, DELETE, LOGIN, LOGOUT, VIEW
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('usuario_id');
        $this->forge->addKey('acao');
        $this->forge->addKey('created_at');
        $this->forge->createTable('logs');
    }

    public function down()
    {
        $this->forge->dropTable('logs');
    }
}

