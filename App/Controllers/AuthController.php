<?php

namespace App\Controllers;

use App\Models\User;
use Mvc\Validation\Validator;

class AuthController
{

    public function signupForm()
    {
        return view('auth.signup');
    }

    public function signup()
    {
        $v = new Validator;
        $v->setRules([
            'username' => 'required|alnum|unique:users,username|between:8,64',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|alnum|between:8,64',
            'password_confirmation' => 'required|alnum|between:8,64',
        ]);

        $v->setAliases(['password_confirmation' => 'Password Confirmation']);

        $v->make(request()->all());

        if (!$v->passes()) {
            app()->session->setFlash('errors', $v->errors());
            app()->session->setFlash('old', [
                'username' => request('username'),
                'email' => request('email'),
            ]);

            return back();
        }

        User::create([
            'username'  => request('username'),
            'email'     => request('email'),
            'password'  => bcrypt(request('password')),
        ]);

        app()->session->setFlash('success', 'Registeraion is successful');

        return back();
    }
}
