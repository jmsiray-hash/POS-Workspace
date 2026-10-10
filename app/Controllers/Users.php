<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        return view('users/index', ['users' => $model->findAll()]);
    }

    public function newUser()
    {
        return view('users/form', [
            'title' => 'Add User',
            'action' => base_url('users/create'),
            'user' => [
                'username' => $this->request->getPost('username'),
                'full_name' => $this->request->getPost('name'),
            ],
        ]);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'name' => 'required',
            'avatar' => 'permit_empty|uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Add User',
                'action' => base_url('users/create'),
                'user' => [
                    'username' => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('name'),
                ],
                'validation' => $this->validator,
            ]);
        }

        $avatar = $this->storeAvatar();
        if ($avatar instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $avatar;
        }

        (new UserModel())->insert([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('name'),
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

        $rules = [
            'username' => 'required|is_unique[users.username,id,' . $id . ']',
            'name' => 'required',
            'avatar' => 'permit_empty|uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Edit User',
                'action' => base_url('users/' . $id . '/update'),
                'user' => [
                    'username' => $this->request->getPost('username'),
                    'full_name' => $this->request->getPost('name'),
                    'avatar' => $user['avatar'] ?? null,
                ],
                'validation' => $this->validator,
            ]);
        }

        $avatar = $this->storeAvatar();
        if ($avatar instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $avatar;
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('name'),
        ];

        if ($avatar !== null) {
            $this->deleteAvatar($user['avatar'] ?? null);
            $data['avatar'] = $avatar;
        }

        $model->update($id, $data);

        return redirect()->to(base_url('users'))->with('message', 'User updated successfully.');
    }

    private function storeAvatar(): string|\CodeIgniter\HTTP\RedirectResponse|null
    {
        $file = $this->request->getFile('avatar');

        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $file->isValid()) {
            return redirect()->back()->withInput()->with('error', $file->getErrorString());
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            return redirect()->back()->withInput()->with('error', 'Unable to create the avatar upload directory.');
        }

        $filename = $file->getRandomName();
        $file->move($directory, $filename);

        return $filename;
    }

    private function deleteAvatar(?string $filename): void
    {
        if ($filename !== null && basename($filename) === $filename) {
            $path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $filename;
            if (is_file($path)) {
                unlink($path);
            }
        }
    }
}