<?php

namespace Frota\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFrotasTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'nome_motorista' => ['type' => 'VARCHAR', 'constraint' => 100],
            'horario_saida' => ['type' => 'DATETIME'],
            'km_saida' => ['type' => 'INT'],
            'horario_retorno' => ['type' => 'DATETIME', 'null' => true],
            'km_retorno' => ['type' => 'INT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('frota');
    }

    public function down() {
        $this->forge->dropTable('frota');
    }
}
