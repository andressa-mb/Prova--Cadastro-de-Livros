<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email, 
            'password' => $request->password
        ];
    }
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->tipoUsuario === 'administrador' || $user->tipoUsuario === 'admin') { 
            return route('admin.dashboard');

        } 
        if ($user->tipoUsuario === 'leitor') {
            return route('livros.index');
        }

        return '/';
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

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
