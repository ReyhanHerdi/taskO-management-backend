<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $data = User::get();
        try {
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'error' => $th
            ]);
        }
    }

    public function show($id) {
        $data = User::where('id_user', $id)->first();
        try {
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'error' => $th
            ]);
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8']
            ]);

            User::factory()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Insert user success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Insert data fail',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $request->validate(['name' => 'required']);
            User::where('id_user', $id)->update(['name' => $request->name]);

            return response()->json([
                'status' => true,
                'message' => 'Update data success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Update data fail',
                'error' => $th->getMessage()
            ]);
        }  
    }
}
