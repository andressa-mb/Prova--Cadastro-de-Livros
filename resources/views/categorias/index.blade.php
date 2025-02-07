<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Livraria</title>
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

@include('header')

<main class="m-4">

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div id="listaCategorias" class="mt-4 table-responsive-lg container">       
    <h2>Lista de Categorias</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col">Livros</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr>
                <td>{{ $categoria->nome }}</td>
                <td>{{ $categoria->descricao }}</td>
                <td>{{ $categoria->livros_count}}</td>
                <td>
                    <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-primary m-2">Exibir</a> 
        <!--        @if(auth()->user() && auth()->user()->is_admin) @endif -->
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-warning m-2">Editar</a> 

                    <a href="{{ route('categorias.showDelete', $categoria->id) }}" class="btn btn-danger">Excluir</a>

                </td>
            </tr>
            @endforeach
        </tbody> 
</div>

</main>   
</body>
</html>
