<?php

namespace App\Controllers;

use App\Libraries\PhotoUploader;
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
                'phone' => $this->request->getPost('phone'),
                'avatar' => null,
            ],
        ]);
    }

    public function create()
    {
        $photo = $this->request->getFile('avatar');
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'full_name' => 'required',
            'phone' => 'permit_empty|max_length[20]',
            'password' => 'required|min_length[8]',
        ];
        if ($photo !== null && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png,image/webp]|max_size[avatar,2048]';
        }

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Add User',
                'action' => base_url('users/create'),
                'user' => [
                    'username' => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                    'phone' => $this->request->getPost('phone'),
                    'avatar' => null,
                ],
                'validation' => $this->validator,
            ]);
        }

        $avatar = $photo !== null && $photo->isValid() ? PhotoUploader::store($photo, 'users') : null;
        (new UserModel())->insert([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'avatar' => $avatar,
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

        $photo = $this->request->getFile('avatar');
        $rules = [
            'username' => 'required|is_unique[users.username,id,' . $id . ']',
            'full_name' => 'required',
            'phone' => 'permit_empty|max_length[20]',
            'password' => 'permit_empty|min_length[8]',
        ];
        if ($photo !== null && $photo->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png,image/webp]|max_size[avatar,2048]';
        }

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Edit User',
                'action' => base_url('users/' . $id . '/update'),
                'user' => [
                    'username' => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('full_name'),
                    'phone' => $this->request->getPost('phone'),
                    'avatar' => $user['avatar'] ?? null,
                ],
                'validation' => $this->validator,
            ]);
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
        ];

        $password = $this->request->getPost('password');
        if ($password !== null && $password !== '') {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($photo !== null && $photo->isValid()) {
            $userData['avatar'] = PhotoUploader::store($photo, 'users');
        }

        $model->update($id, $userData);

        if (isset($userData['avatar'])) {
            PhotoUploader::remove($user['avatar'] ?? null, 'users');
        }

        return redirect()->to(base_url('users'))->with('message', 'User updated successfully.');
    }

    public function delete(int $id)
    {
        $session = session();
        $deletingCurrentUser = (int) $session->get('user_id') === $id;

        $model = new UserModel();
        $user = $model->find($id);
        if ($user === null) {
            return redirect()->to(base_url('users'))->with('error', 'User not found.');
        }

        if (! empty($user['is_admin'])) {
            return redirect()->to(base_url('users'))->with('error', 'The admin account cannot be deleted.');
        }

        $model->delete($id);
        PhotoUploader::remove($user['avatar'] ?? null, 'users');

        if ($deletingCurrentUser) {
            $session->destroy();

            return redirect()->to(base_url('login'));
        }

        return redirect()->to(base_url('users'))->with('message', 'User deleted successfully.');
    }
}