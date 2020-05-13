<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class AuthController extends ApiController
{

    /**
     * @route   POST api/v1/auth/register
     * @desc    Register new user
     * @type    PUBLIC
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        return $this->success($user, 200);
    }

    /**
     * @route   POST api/v1/auth/login
     * @desc    Login user
     * @type    PUBLIC
     */
    public function login(LoginRequest $request)
    {
        $crenditials = $request->only('email', 'password');
        if ($token = Auth::guard()->attempt($crenditials)) {
            return $this->success($token, 200)->header('Authorization', $token);
        } else {
            return $this->fail('Loggin error', 401);
        }
    }

    /**
     * @route   GET api/v1/auth/refresh
     * @desc    Refresh token JWT
     * @type    PUBLIC
     */
    public function refresh()
    {
        if ($token = Auth::guard()->refresh()) {
            return $this->success($token)->header('Authorization', $token);
        }
    }

    /**
     * @route   POST api/v1/auth/user
     * @desc    Get info user
     * @type    Private
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return $this->success($user);
    }

    /**
     * @route   POST api/v1/auth/logout
     * @desc    Logout user 
     * @type    Private
     */
    public function logout()
    {
        Auth::guard()->logout();
        return $this->success('Success logout');
    }
}
