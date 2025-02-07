<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Livraria</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
@include('header')
@extends('layouts.app')
<main class="m-4">
@section('content')
@if(session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h2>Editar Categoria</h2>
    <form id="formEdit" action="{{ route('categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
        @csrf    
        @method('PUT')
        <div class="form-group w-50">
            <label for="nomeCategoria" class="form-label">Nome da categoria:</label>
            <input type="text" name="nome" id="inputNomeCat" class="form-control @error('nome') is-invalid @enderror" value="{{ $categoria->nome }}" required>
        </div>
        <div class="form-group w-50">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" id="inputDescricao" class="form-control @error('descricao') is-invalid @enderror" value="{{ $categoria->descricao }}">
        </div>
        <div class="form-group w-50">
            <label for="livrosAssociados" class="form-label">Livros Associados</label>
            <div class="border p-3 rounded">
                @foreach($livros as $livro)
                    <div class="form-check">
                        <input type="checkbox" name="livros[]" value="{{ $livro->id }}" class="form-check-input" id="livro_{{ $livro->id }}"
                        @if(in_array($livro->id, $categoria->livros->pluck('id')->toArray())) checked @endif>
                        <label class="form-check-label" for="livro_{{ $livro->id }}">{{ $livro->titulo }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-success" id="salvarCategoria">Salvar</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</main>
</body>
</html>