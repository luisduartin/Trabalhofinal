<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImoveisTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'titulo'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'descricao'    => ['type' => 'TEXT'],
            'preco_venda'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'preco_aluguel' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'finalidade'   => ['type' => 'VARCHAR', 'constraint' => 20],
            'bairro_id'    => ['type' => 'INT'],
            'tipo_imovel_id' => ['type' => 'INT'],
            'usuario_id'   => ['type' => 'INT'], // dono imóvel (corretor)
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('imoveis');
    }

    public function down()
    {
        $this->forge->dropTable('imoveis');
    }
}
