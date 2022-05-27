<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/tag';

    public function __construct()
    {
        $this->guardName = 'admin';
        // parent::__construct();
    }

    public function showLoginForm()
    {
        // return view('admin.login');
        return redirect(route('admin.dashboard'));
    }

    public function login(\App\Http\Requests\AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['role_id'] = \App\Enums\UserRole::ADMINISTRATOR;

        if (auth('admin')->attempt($credentials, $request->filled('remember'))) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
