<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de inicio de sesión.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar el inicio de sesión.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        // Obtenemos el rol del usuario autenticado
        $user = Auth::user();

        // Redirigir según su rol
        switch ($user->roles_id) {
            case '1':
                return redirect()->route('dashboard.admin');
            case '2':
                return redirect()->route('dashboard.instructor');
            case '3':
                return redirect()->route('dashboard.lider');
            default:
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Rol no autorizado.']);
        }
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('email');
}


    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}