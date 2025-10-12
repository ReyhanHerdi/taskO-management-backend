<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authCheck() {
        $auth = auth()->guard('api');
        if ($auth->check()) {
            return response()->json([
                'status' => true,
                'message' => 'User has login',
                'data' => $auth->user()->id_user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User has not login',
            ]);
        }
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $auth = auth()->guard('api');

        try {
            if ($auth->attempt($credentials)) {
                return $this->authCheck();
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Email or password is wrong'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Login fail',
                'error' => $th->getMessage()
            ]);
        }
    }
}
