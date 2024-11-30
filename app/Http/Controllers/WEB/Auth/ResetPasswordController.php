<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetSuccess;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index($token)
    {
        session(['password_reset_token' => $token]);
        return view('pages.auth.reset.reset-password', ['token' => $token]);
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|string',
                'token' => 'required|string',
            ],
            [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email harus valid',
            ]
        );

        $token = session('password_reset_token');

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $token,
            ])->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token or email!');
        }

        $mahasiswa = Mahasiswa::where('email', $request->email)->first();

        $defaultPassword = '@Poli' . $mahasiswa->nim;
        $mahasiswa->update(['password' => Hash::make($defaultPassword)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        Mail::to($mahasiswa->email)->send(new PasswordResetSuccess($mahasiswa, $defaultPassword));

        return redirect()->route('login.index')->with('success', 'Password berhasil direset. Silakan login dengan NIM sebagai password.');
    }
}
