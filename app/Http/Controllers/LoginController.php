<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    protected function guard()  
    {
        return Auth::guard('guard-name');
    }
   

    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->tipoUsuario === 'administrador' || $user->tipoUsuario === 'admin') { 
            return redirect()->intended('admin.dashboard');

        } 
        if ($user->tipoUsuario === 'leitor') {
            echo "leitor ";
            return '/';
        }

        return '/';
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        Log::info("credenciais do controller loggin " + $credentials);

        if (Auth::attempt($credentials)) {
            return redirect($this->redirectTo()); 
        }
    
        return back()->withErrors(['email' => 'Email ou senha inválidos.']);
    }

    public function register(Request $request){

        dd($request->all());
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:usuarios,email|max:120',
            'password' => 'required|min:6|max:12|confirmed',
            'password_confirmation' => 'required|same:password',
             'tipoUsuario' => 'required|in:admin,leitor'
        ]);

        User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipoUsuario' => $request->tipoUsuario,
        ]);

        return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
    }

}
