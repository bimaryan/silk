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

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('pages.auth.reset.index');
    }

    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:mahasiswas,email',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => carbon::now()
        ]);

        Mail::send('pages.auth.email.index', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->route('login.index')->with('success', 'Kami telah mengirimkan link untuk mereset kata sandi Anda melalui email!');
    }
}
