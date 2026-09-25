<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();
        
        // Kinukuha ang lahat ng records mula sa 'customers' table sa database
        $data['customers'] = $model->findAll();

        return view('customers/index', $data);
    }
}