<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAvatarToCustomers extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('avatar', 'customers')) {
            $this->forge->addColumn('customers', [
                'avatar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('avatar', 'customers')) {
            $this->forge->dropColumn('customers', 'avatar');
        }
    }
}
