@include('header')
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Dashboard</h2>
    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

    
    <div class="row">
        
        <div class="col-md-3">
            <a href="{{ route('livros.index') }}">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Livros</h5>
                    </div>
                </div>
            </a>
        </div>

        
        <div class="col-md-3">
            <a href="{{ route('categorias.index') }}">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Categorias</h5>
                    </div>
                </div>
            </a>
        </div>

        
        <div class="col-md-3">
            <a href="{{ route('autores.index') }}">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Autores</h5>
                    </div>
                </div>
            </a>
        </div>

        
        @if(Auth::user() && Auth::user()->tipoUsuario === 'admin')
        <div class="col-md-3">
            <a href="{{ route('admin.lista') }}">
                <div class="card text-center bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Administradores</h5>
                    </div>
                </div>
            </a>
        </div>
        @endif
    
    </div>
</div>
@endsection