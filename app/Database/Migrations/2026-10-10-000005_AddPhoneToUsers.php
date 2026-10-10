<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhoneToUsers extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('phone', 'users')) {
            $this->forge->addColumn('users', [
                'phone' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('phone', 'users')) {
            $this->forge->dropColumn('users', 'phone');
        }
    }
}
