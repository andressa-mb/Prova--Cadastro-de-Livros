<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->tipoUsuario === 'administrador') {
            return view('admin.dashboard');
        }

        return redirect()->route('/')->with('error', 'Acesso não autorizado.');
    }

    public function listaAdmins()
    {
        $admins = User::where('tipoUsuario', 'administrador')->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.cadastro');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:120|unique:usuarios,email',
            'senha' => 'required|string|min:6|max:12|confirmed',
        ]);

        if (Auth::user()->tipoUsuario !== 'administrador' && Auth::user()->tipoUsuario !== 'admin') {
            return redirect()->route('admin.cadastro')->with('error', 'Você não tem permissão para cadastrar administradores.');
        }

        if (Auth::user()->email === $request->email) {
            return redirect()->route('admin.cadastro')->with('error', 'Você não pode se cadastrar como administrador.');
        }

        $admin = new User();
        $admin->nome = $request->nome;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->senha);
        $admin->tipoUsuario = 'administrador';
        $admin->save();

        return redirect()->route('admin.dashboard')->with('success', 'Administrador cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'nome' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:120|unique:usuarios,email,' . $id,
        ]);
        $admin = User::findOrFail($id);

        $admin->nome = $request->input('nome');
        $admin->email = $request->input('email');
    
        $admin->tipoUsuario = 'administrador';
    
        $admin->save();

        return redirect()->route('admin.dashboard')->with('success', 'Administrador atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Administrador excluído com sucesso!');
    }
}
