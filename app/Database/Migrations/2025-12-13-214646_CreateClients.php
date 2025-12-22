<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Models\ClientModel;

class CreateClients extends Migration
{
    public function up()
    {
        $this->forge->addField([
            ClientModel::ID => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            ClientModel::NAME => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            ClientModel::EMAIL => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            ClientModel::PHONENUMBER => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            ClientModel::CPF => [
                'type'       => 'VARCHAR',
                'constraint' => 14,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey(ClientModel::ID, true);
        $this->forge->createTable(ClientModel::TABLE, true);
    }

    public function down()
    {
        $this->forge->dropTable(ClientModel::TABLE, true);
    }
}
