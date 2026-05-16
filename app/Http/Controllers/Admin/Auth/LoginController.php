<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Support\Traits\HasErrorLogging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

final class LoginController extends Controller
{
    use HasErrorLogging;

    public function showLoginForm()
    {
        try {
            return view('admin.auth.login');
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao carregar tela de login', get_called_class().'@'.__FUNCTION__);
            abort(500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.home'));
            }

            return back()->withErrors([
                'email' => 'As credenciais informadas não conferem.',
            ])->onlyInput('email');
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao realizar login', get_called_class().'@'.__FUNCTION__);
            return redirect()->back()->withErrors(['message' => 'Erro inesperado. Tente novamente.']);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao realizar logout', get_called_class().'@'.__FUNCTION__);
            return redirect()->route('admin.login');
        }
    }
}
