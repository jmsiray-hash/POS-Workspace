<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        // Static array of at least 5 sample user records
        $users = [
            ['id' => 1, 'username' => 'admin_user', 'role' => 'Administrator', 'status' => 'Active', 'last_login' => '2026-09-24'],
            ['id' => 2, 'username' => 'cashier_01', 'role' => 'Cashier', 'status' => 'Active', 'last_login' => '2026-09-23'],
            ['id' => 3, 'username' => 'cashier_02', 'role' => 'Cashier', 'status' => 'Inactive', 'last_login' => '2026-09-20'],
            ['id' => 4, 'username' => 'manager_01', 'role' => 'Store Manager', 'status' => 'Active', 'last_login' => '2026-09-24'],
            ['id' => 5, 'username' => 'inventory_clerk', 'role' => 'Inventory Staff', 'status' => 'Active', 'last_login' => '2026-09-22'],
        ];

        $data = [
            'title' => 'User Accounts',
            'users' => $users,
        ];

        return view('templates/header', $data)
            . view('users/index', $data)
            . view('templates/footer');
    }
}