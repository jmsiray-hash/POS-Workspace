<?php

namespace App\Controllers;

use App\Libraries\PhotoUploader;
use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();

        return view('customers/index', [
            'title' => 'Customers',
            'customers' => $model->findAll(),
        ]);
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
        $photo = $this->request->getFile('avatar');
        $rules = [
            'full_name' => 'required',
            'email' => 'required|valid_email',
        ];
        if ($photo !== null && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png,image/webp]|max_size[avatar,2048]';
        }

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'title' => 'Add Customer',
                'action' => base_url('customers/create'),
                'customer' => [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'avatar' => null,
                ],
                'validation' => $this->validator,
            ]);
        }

        $model = new CustomerModel();
        $avatar = $photo !== null && $photo->isValid() ? PhotoUploader::store($photo, 'customers') : null;
        $model->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'avatar' => $avatar,
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
        $model = new CustomerModel();
        $customer = $model->find($id);
        if ($customer === null) {
            return redirect()->to(base_url('customers'))->with('error', 'Customer not found.');
        }

        $photo = $this->request->getFile('avatar');
        $rules = [
            'full_name' => 'required',
            'email' => 'required|valid_email',
        ];
        if ($photo !== null && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png,image/webp]|max_size[avatar,2048]';
        }

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'title' => 'Edit Customer',
                'action' => base_url('customers/' . $id . '/update'),
                'customer' => [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'avatar' => $customer['avatar'] ?? null,
                ],
                'validation' => $this->validator,
            ]);
        }

        $avatar = $customer['avatar'] ?? null;
        if ($photo !== null && $photo->isValid()) {
            $newAvatar = PhotoUploader::store($photo, 'customers');
        }

        $model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'avatar' => $newAvatar ?? $avatar,
        ]);

        if (isset($newAvatar)) {
            PhotoUploader::remove($avatar, 'customers');
        }

        return redirect()->to(base_url('customers'))->with('message', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();

        if ($model->find($id) === null) {
            return redirect()->to(base_url('customers'))->with('error', 'Customer not found.');
        }

        $model->delete($id);
        PhotoUploader::remove($customer['avatar'] ?? null, 'customers');

        return redirect()->to(base_url('customers'))->with('message', 'Customer deleted successfully.');
    }
}