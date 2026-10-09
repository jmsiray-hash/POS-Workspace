<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->orderBy('id', 'ASC')->findAll();

        return view('users/index', $data);
    }

    public function new()
    {
        return view('users/form', [
            'user' => [],
            'errors' => [],
            'mode' => 'create',
            'title' => 'Add User',
        ]);
    }

    public function create()
    {
        $data = [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|min_length[2]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'user' => $data,
                'errors' => $this->validator->getErrors(),
                'mode' => 'create',
                'title' => 'Add User',
            ]);
        }

        $data['created_at'] = date('Y-m-d H:i:s');

        $model = new UserModel();
        $model->insert($data);

        return redirect()->to('/users')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw new PageNotFoundException('User not found');
        }

        return view('users/form', [
            'user' => $user,
            'errors' => [],
            'mode' => 'edit',
            'title' => 'Edit User',
        ]);
    }

    public function update($id)
    {
        $model = new UserModel();

        if ($model->find($id) === null) {
            throw new PageNotFoundException('User not found');
        }

        $userData = [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,' . (int) $id . ']',
            'full_name' => 'required|min_length[2]|max_length[100]',
        ];

        $avatarFile = $this->request->getFile('avatar');
        $avatarName = null;

        if ($avatarFile !== null && $avatarFile->isValid() && ! $avatarFile->hasMoved()) {
            $allowedMimeTypes = ['image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024;

            if (! in_array($avatarFile->getClientMimeType(), $allowedMimeTypes, true)) {
                return view('users/form', [
                    'user' => array_merge(['id' => $id], $userData),
                    'errors' => ['avatar' => 'The avatar must be a JPG or PNG image.'],
                    'mode' => 'edit',
                    'title' => 'Edit User',
                ]);
            }

            if ($avatarFile->getSize() > $maxSize) {
                return view('users/form', [
                    'user' => array_merge(['id' => $id], $userData),
                    'errors' => ['avatar' => 'The avatar must not exceed 2MB.'],
                    'mode' => 'edit',
                    'title' => 'Edit User',
                ]);
            }

            $uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $avatarName = $avatarFile->getRandomName();
            $avatarFile->move($uploadDir, $avatarName);

            $image = \Config\Services::image()
                ->withFile($uploadDir . DIRECTORY_SEPARATOR . $avatarName)
                ->resize(200, 200, true, 'auto');

            $preparedName = 'thumb_' . $avatarName;
            $image->save($uploadDir . DIRECTORY_SEPARATOR . $preparedName);
            $avatarName = $preparedName;

            if ($existingUser = $model->find($id)) {
                $oldAvatar = $existingUser['avatar'] ?? null;
                if ($oldAvatar && $oldAvatar !== 'default-avatar.svg' && file_exists($uploadDir . DIRECTORY_SEPARATOR . $oldAvatar)) {
                    unlink($uploadDir . DIRECTORY_SEPARATOR . $oldAvatar);
                }
            }
        }

        if (! $this->validate($rules)) {
            return view('users/form', [
                'user' => array_merge(['id' => $id], $userData),
                'errors' => $this->validator->getErrors(),
                'mode' => 'edit',
                'title' => 'Edit User',
            ]);
        }

        $existingUser = $model->find($id);
        $avatarName = $avatarName ?? ($existingUser['avatar'] ?? null);

        if ($avatarName !== null) {
            $userData['avatar'] = $avatarName;
        }

        $model->update($id, $userData);

        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }
}