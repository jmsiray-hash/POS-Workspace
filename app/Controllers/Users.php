<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        return view('users/index', [
            'title' => 'Users',
            'users' => $model->findAll(),
        ]);
    }

    public function newUser()
    {
        return view('users/form', [
            'title' => 'Add User',
            'action' => base_url('users/create'),
            'user' => [
                'username' => $this->request->getPost('username'),
                'full_name' => $this->request->getPost('full_name'),
            ],
        ]);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'full_name' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Add User',
                'action' => base_url('users/create'),
                'user' => [
                    'username' => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                ],
                'validation' => $this->validator,
            ]);
        }

        (new UserModel())->insert([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('users'))->with('message', 'User added successfully.');
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            return redirect()->to(base_url('users'))->with('error', 'User not found.');
        }

        return view('users/form', [
            'title' => 'Edit User',
            'action' => base_url('users/' . $id . '/update'),
            'user' => $user,
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            return redirect()->to(base_url('users'))->with('error', 'User not found.');
        }

        $rules = [
            'username' => 'required|is_unique[users.username,id,' . $id . ']',
            'full_name' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Edit User',
                'action' => base_url('users/' . $id . '/update'),
                'user' => [
                    'username' => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                ],
                'validation' => $this->validator,
            ]);
        }

        $model->update($id, [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ]);

        return redirect()->to(base_url('users'))->with('message', 'User updated successfully.');
    }
}