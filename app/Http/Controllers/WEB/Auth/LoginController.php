<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        $captcha = $this->generateCaptcha(6);
        Session::put('captcha', $captcha);
        return view("pages.auth.login.index", ['captcha' => $captcha]);
    }

    private function generateCaptcha($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $captcha = '';

        // Menghasilkan CAPTCHA
        for ($i = 0; $i < $length; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $captcha;
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required|min:6',
            'captcha' => 'required|same:captcha',
        ], [
            'identifier.required' => 'Username/NIM harus diisi',
            'password.required' => 'Kata sandi harus diisi',
            'captcha.required' => 'CAPTCHA harus diisi',
            'captcha.same' => 'CAPTCHA yang dimasukkan salah',
        ]);

        if ($request->captcha != Session::get('captcha')) {
            return redirect()->back()->with('error', 'CAPTCHA yang dimasukkan salah')->withInput();
        }

        $credentials = $request->only('identifier', 'password');

        if (Auth::guard('admin')->attempt(['username' => $credentials['identifier'], 'password' => $request->password])) {
            $role = Auth::guard('admin')->user()->role_id;
            if ($role == 1 || $role == 2) {
                return redirect()->route('dashboard.index');
            } else {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke dashboard')->withInput();
            }
        }

        if (Auth::guard('mahasiswa')->attempt(['nim' => $credentials['identifier'], 'password' => $request->password])) {
            return redirect()->route('beranda.index');
        }

        if (Auth::guard('dosen')->attempt(['username' => $credentials['identifier'], 'password' => $request->password])) {
            return redirect()->route('beranda.index');
        }

        return redirect()->back()->with('error', 'Username/NIM atau kata sandi salah')->withInput();
    }
}
