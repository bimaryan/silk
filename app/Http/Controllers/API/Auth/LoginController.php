<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'identifier' => 'required',
            'password' => 'required|min:6',
        ], [
            'identifier.required' => 'Username/NIM harus diisi',
            'password.required' => 'Kata sandi harus diisi',
        ]);

        $credentials = $request->only('identifier', 'password');

        if (Auth::guard('mahasiswa')->attempt(['nim' => $credentials['identifier'], 'password' => $credentials['password']])) {
            $user = Auth::guard('mahasiswa')->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Berhasil masuk sebagai mahasiswa',
                'user' => $user->id,
                'token' => $token,
            ]);
        }

        return response()->json(['error' => 'Kredensial tidak valid.'], 401);
    }
}
