<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminFlagToUsers extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('is_admin', 'users')) {
            $this->forge->addColumn('users', [
                'is_admin' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => false,
                ],
            ]);
        }

        $this->db->table('users')
            ->groupStart()
                ->where('username', 'Mr.D')
                ->orWhere('full_name', 'George Siray')
            ->groupEnd()
            ->update(['is_admin' => 1]);
    }

    public function down()
    {
        if ($this->db->fieldExists('is_admin', 'users')) {
            $this->forge->dropColumn('users', 'is_admin');
        }
    }
}
