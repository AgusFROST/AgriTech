<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use App\Notifications\CustomResetPassword;


class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil.');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);


        User::create([
            'uid' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah logout.');
    }


    // Show form for forgot password
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email belum terdaftar.']);
        }

        $token = app('auth.password.broker')->createToken($user);
        $user->notify(new CustomResetPassword($token));

        return back()->with('success', 'Link reset telah dikirim ke email Anda.');
    }


    // Show form reset
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Handle reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect('/')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }


}
