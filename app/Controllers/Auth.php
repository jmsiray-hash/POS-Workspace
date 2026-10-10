<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        $session = session();

        if ($session->get('isLoggedIn')) {
            return redirect()->to(base_url('customers'));
        }

        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('auth/login', [
                'title' => 'Login',
            ]);
        }

        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return view('auth/login', [
                'title' => 'Login',
                'error' => 'Invalid username or password.',
                'username' => $username,
            ]);
        }

        $session->regenerate(true);
        $session->set([
            'isLoggedIn' => true,
            'user_id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
        ]);

        return redirect()->to(base_url('customers'));
    }

    public function signup()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('customers'));
        }

        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('auth/signup', [
                'title' => 'Sign Up',
            ]);
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return view('auth/signup', [
                'title' => 'Sign Up',
                'validation' => $this->validator,
            ]);
        }

        (new UserModel())->insert([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('login'))
            ->with('message', 'Account created successfully. Please log in.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}
