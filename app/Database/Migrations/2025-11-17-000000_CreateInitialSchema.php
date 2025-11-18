<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialSchema extends Migration
{
    public function up()
    {
        $this->createUsuariosTable();
        $this->createBairrosTable();
        $this->createTiposImoveisTable();
        $this->createImoveisTable();
        $this->createFotosImoveisTable();
        $this->createLogsTable();
    }

    public function down()
    {
        $this->forge->dropTable('logs', true);
        $this->forge->dropTable('fotos_imoveis', true);
        $this->forge->dropTable('imoveis', true);
        $this->forge->dropTable('tipos_imoveis', true);
        $this->forge->dropTable('bairros', true);
        $this->forge->dropTable('usuarios', true);
    }

    private function createUsuariosTable(): void
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

        // Inserir usuário administrador padrão
        $data = [
            'nome'      => 'Administrador',
            'email'     => 'admin@sistema.com',
            'senha'     => password_hash('123456', PASSWORD_DEFAULT),
            'tipo'      => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('usuarios')->insert($data);
    }

    private function createBairrosTable(): void
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'auto_increment' => true],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 150],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bairros');

        // Inserir bairros pré-definidos
        $bairros = [
            'Alvorada',
            'Arco-íris',
            'Bela Vista',
            'Centro',
            'Erica',
            'Esperança',
            'Fátima',
            'Fritsch',
            'Jaciandi',
            'Jardim Paraguai',
            'Kuhn',
            'Medianeira',
            'Morro Grosse',
            'Pavão',
            'Piratini',
            'Planalto',
            'São Jorge',
            'Serrano',
            'Timbará',
            'Trentini',
            'Vila Nova',
            'Zona Norte',
            'Alto Paraíso'
        ];

        foreach ($bairros as $bairro) {
            $this->db->table('bairros')->insert(['nome' => $bairro]);
        }
    }

    private function createTiposImoveisTable(): void
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'auto_increment' => true],
            'nome' => ['type' => 'VARCHAR', 'constraint' => 150],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tipos_imoveis');

        // Inserir tipos de imóveis pré-definidos
        $tipos = [
            'Apartamento',
            'Casa',
            'Terreno'
        ];

        foreach ($tipos as $tipo) {
            $this->db->table('tipos_imoveis')->insert(['nome' => $tipo]);
        }
    }

    private function createImoveisTable(): void
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

    private function createFotosImoveisTable(): void
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

    private function createLogsTable(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'comment'        => 'Chave primária do log',
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'comment'    => 'ID do usuário que realizou a ação',
            ],
            'acao' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'comment'    => 'Tipo de ação: CREATE, UPDATE, DELETE, LOGIN, LOGOUT, VIEW',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'comment' => 'Data e hora da ação',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('usuario_id', false, false, 'idx_usuario_id');
        $this->forge->addKey('acao', false, false, 'idx_acao');
        $this->forge->addKey('created_at', false, false, 'idx_created_at');

        $this->forge->createTable('logs', true, [
            'ENGINE'  => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_general_ci',
            'COMMENT' => 'Tabela de log de ações do sistema',
        ]);
    }
}


