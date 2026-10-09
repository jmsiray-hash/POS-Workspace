<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();
        $data['customers'] = $model->orderBy('id', 'ASC')->findAll();

        return view('customers/index', $data);
    }

    public function new()
    {
        return view('customers/form', [
            'customer' => [],
            'errors' => [],
            'mode' => 'create',
            'title' => 'Add Customer',
        ]);
    }

    public function create()
    {
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'customer' => $data,
                'errors' => $this->validator->getErrors(),
                'mode' => 'create',
                'title' => 'Add Customer',
            ]);
        }

        $data['created_at'] = date('Y-m-d H:i:s');

        $model = new CustomerModel();
        $model->insert($data);

        return redirect()->to('/customers')->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if ($customer === null) {
            throw new PageNotFoundException('Customer not found');
        }

        return view('customers/form', [
            'customer' => $customer,
            'errors' => [],
            'mode' => 'edit',
            'title' => 'Edit Customer',
        ]);
    }

    public function update($id)
    {
        $model = new CustomerModel();

        if ($model->find($id) === null) {
            throw new PageNotFoundException('Customer not found');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        $rules = [
            'full_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'customer' => array_merge(['id' => $id], $data),
                'errors' => $this->validator->getErrors(),
                'mode' => 'edit',
                'title' => 'Edit Customer',
            ]);
        }

        $model->update($id, $data);

        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }
}