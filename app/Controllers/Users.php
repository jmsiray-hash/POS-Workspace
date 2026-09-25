<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        // Kinukuha ang lahat ng records mula sa 'users' table sa database
        $data['users'] = $model->findAll();

        return view('users/index', $data);
    }
}