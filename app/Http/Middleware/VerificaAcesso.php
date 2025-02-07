<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerificaAcesso
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
    
        $tipoUsuario = Auth::user()->tipoUsuario;
    
        if ($tipoUsuario !== 'administrador' && $tipoUsuario !== 'admin') {
            return redirect('/')->with('error', 'Acesso não autorizado.');
        }
    
        return $next($request); 
    }
}
