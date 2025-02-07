<body>

<header class=" p-4 bg-white shadow-sm">
    <h1>Sistema da Livraria</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('livros*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Livros</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('livros.index') }}">Lista de Livros</a>
                        @if(Auth::user() && (Auth::user()->tipoUsuario === 'administrador' || Auth::user()->tipoUsuario === 'admin'))
                        <a class="dropdown-item" href="{{ route('livros.cadastro') }}">Cadastro de Livros</a>
                        @endif
                    </div>
                </li>
                @if(Auth::check() && (Auth::user()->tipoUsuario === 'administrador' || Auth::user()->tipoUsuario === 'admin'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('categorias*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorias</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('categorias.index') }}">Lista de Categorias</a>
                        <a class="dropdown-item" href="{{ route('categorias.cadastro') }}">Cadastro de Categorias</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('autores*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Autores</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('autores.index') }}">Lista de Autores</a>
                        <a class="dropdown-item" href="{{ route('autores.cadastro') }}">Cadastro de Autores</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('admin**') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administradores</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.lista') }}">Lista de Administradores</a>
                        <a class="dropdown-item" href="{{ route('admin.cadastro') }}">Cadastro de Administradores</a>
                    </div>
                </li>
                @endif
            </ul>
        </div>

        @if(Auth::check())
            <span class="navbar-text mx-4">Bem-vindo, {{ Auth::user()->tipoUsuario }} {{ Auth::user()->nome }}!</span>
            <a class="btn btn-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a class="btn btn-primary" href="{{ route('login') }}" role="button">Login</a>
        @endif
        
    </nav>
</header>
@extends('layouts.app')

</body>