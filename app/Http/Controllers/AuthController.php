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
        // Si el usuario ya está autenticado, redirigirlo directamente a su dashboard
        if (Auth::check()) {
            return $this->redirectByUserRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Procesar el inicio de sesión.
     * Implementa la funcionalidad de "Recordarme" y redirección por roles.
     */
    public function login(Request $request)
    {
        // 1. Validación de credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // 2. Intentar la autenticación con la opción "Recordarme"
        // El método filled('remember') devuelve true si el checkbox fue marcado.
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            // 3. Éxito: Regenerar la sesión para seguridad
            $request->session()->regenerate();

            // 4. Obtener el usuario y redirigir según su rol
            $user = Auth::user();
            return $this->redirectByUserRole($user);
        }

        // 5. Error: Redirigir de vuelta con mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Lógica centralizada para redirigir según el rol del usuario.
     */
    private function redirectByUserRole($user)
    {
        // Redirigir según su roles_id (1: Admin, 2: Instructor, 3: Líder)
        switch ($user->roles_id) {
            case '1':
                return redirect()->route('dashboard.admin');
            case '2':
                return redirect()->route('dashboard.instructor');
            case '3':
                return redirect()->route('dashboard.lider');
            default:
                // Si el rol no es reconocido, cerrar sesión por seguridad
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Rol no autorizado en el sistema.']);
        }
    }

    /**
     * Cerrar sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida la sesión del usuario y regenera el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Has cerrado sesión correctamente.');
    }
}
