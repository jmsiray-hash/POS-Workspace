<?php

namespace App\Controllers;

class Customers extends BaseController
{
    public function index()
    {
        // Static array of at least 5 sample customer records
        $customers = [
            ['id' => 1, 'name' => 'Juan Dela Cruz', 'email' => 'juan@example.com', 'phone' => '09171234567', 'city' => 'Quezon City'],
            ['id' => 2, 'name' => 'Maria Clara', 'email' => 'maria@example.com', 'phone' => '09182345678', 'city' => 'Manila'],
            ['id' => 3, 'name' => 'Jose Rizal', 'email' => 'jose@example.com', 'phone' => '09193456789', 'city' => 'Calamba'],
            ['id' => 4, 'name' => 'Andres Bonifacio', 'email' => 'andres@example.com', 'phone' => '09204567890', 'city' => 'Tondo'],
            ['id' => 5, 'name' => 'Apolinario Mabini', 'email' => 'apolinario@example.com', 'phone' => '09215678901', 'city' => 'Tanauan'],
        ];

        $data = [
            'title'     => 'Customer Accounts',
            'customers' => $customers,
        ];

        return view('templates/header', $data)
            . view('customers/index', $data)
            . view('templates/footer');
    }
}