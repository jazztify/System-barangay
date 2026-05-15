<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('username', $credentials['username'])
            ->where('is_active', true)
            ->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password_hash)) {
            auth()->login($user);
            $user->update(['last_login' => now()]);
            \App\Models\AuditLog::create([
                'user_id' => $user->user_id,
                'action' => 'LOGIN',
                'entity_type' => 'User',
                'entity_id' => $user->user_id,
                'ip_address' => $request->ip(),
            ]);
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['username' => 'Invalid credentials or inactive account.']);
    }

    public function logout(Request $request)
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'LOGOUT',
            'entity_type' => 'User',
            'entity_id' => auth()->id(),
            'ip_address' => $request->ip(),
        ]);
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}