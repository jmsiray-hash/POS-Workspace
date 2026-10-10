<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();

        return view('customers/index', ['customers' => $model->findAll()]);
    }

    public function newCustomer()
    {
        return view('customers/form', [
            'title' => 'Add Customer',
            'action' => base_url('customers/create'),
            'customer' => [
                'full_name' => $this->request->getPost('full_name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
            ],
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required',
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'title' => 'Add Customer',
                'action' => base_url('customers/create'),
                'customer' => [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                ],
                'validation' => $this->validator,
            ]);
        }

        $model = new CustomerModel();
        $model->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('customers'))->with('message', 'Customer added successfully.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            return redirect()->to(base_url('customers'))->with('error', 'Customer not found.');
        }

        return view('customers/form', [
            'title' => 'Edit Customer',
            'action' => base_url('customers/' . $id . '/update'),
            'customer' => $customer,
        ]);
    }

    public function update(int $id)
    {
        $rules = [
            'full_name' => 'required',
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'title' => 'Edit Customer',
                'action' => base_url('customers/' . $id . '/update'),
                'customer' => [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                ],
                'validation' => $this->validator,
            ]);
        }

        $model = new CustomerModel();
        if ($model->find($id) === null) {
            return redirect()->to(base_url('customers'))->with('error', 'Customer not found.');
        }

        $model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ]);

        return redirect()->to(base_url('customers'))->with('message', 'Customer updated successfully.');
    }
}