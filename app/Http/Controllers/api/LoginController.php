<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginApi(Request $request)
    {
        $result['is_valid'] = false;

        try {

            $loginData = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            // cek apakah ada datanya tidak di model User
            $user = User::where('username', $loginData['username'])->first();
            if (!$user) {
                $result['message'] = "username tidak ditemukan";
                $result['is_valid'] = false;
                return response()->json($result);
            }

            // cek apakah passwordnya sama
            if (!Auth::attempt($loginData)) {
                $result['message'] = "Password salah";
                $result['is_valid'] = false;
                return response()->json($result);
            }

            $token = Auth::user()->createToken('authToken')->plainTextToken;


            $result['data'] = Auth::user();
            $result['token'] = $token;



            $result['is_valid'] = true;
        } catch (\Throwable $th) {
            $result['message'] = $th->getMessage();
        }

        return response()->json($result);
    }
}
