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
@section('content')
<main class="m-4">
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
    <div id="livro">
        <h1 class="text-center">{{ $livro->titulo }}</h1>
        <img src="{{ $livro->capa ? asset('storage/'. $livro->capa) : asset('imagens/capa.png') }}" alt='Capa Livro' width="150" class="rounded mx-auto d-block"> 
    </div>
    <div id="editora">
        <h4>Editora:</h4>
        <p>{{ $livro->editora }}</p>
    </div>
    <div id="data_publicacao">
        <h4>Data da publicação</h4>        
        <p>{{ $livro->data_publicacao}}</p>
    </div>
    <div id="keywords">
        <h4>Keywords</h4>
        @if(!empty($livro->keywords))
            <p>{{ $livro->keywords }}</p>
        @else
            <p>Nenhuma keyword disponível.</p>
        @endif
    </div>
    <div id="autores" class="mr-auto">
        <h4>Autores</h4>
        <ul class="list-unstyled">
            @foreach($livro->autores as $autor)
                <li>{{ $autor->nome }}</li>
            @endforeach
        </ul>
    </div>
    <div id="categorias" class="mb-5">
        <h4>Categorias</h4>
        <ul class="list-unstyled">
            @foreach($livro->categorias as $categoria)
                <li>{{ $categoria->nome }}</li>
            @endforeach
        </ul>
    </div>

    <div class="m-4">
        
        @if(Auth::check() && Auth::user()->tipoUsuario !== 'administrador')
        <form action="{{ route('favorito.store', $livro->id) }}" method="POST">
            @csrf
            <div class="btn-group-toggle" data-toggle="buttons">
                <button type="submit"  class="btn btn-primary 
                @if($favorito) active @endif" autocomplete="off">
                
                @if($favorito)
                    ☆ Remover dos favoritos
                @else
                    ★ Adicionar aos favoritos
                @endif
            </button>
                
            </div>
        </form>
        
    </div> 

    
    <form action="{{ route('comentario.store', $livro->id) }}" method="POST">
        @csrf
        <input type="hidden" name="livro_id" value="{{ $livro->id }}">
        <h4>Deixe seu comentário ou pontuação</h4>
        <div class="form-group d-flex w-50">
            <textarea name="comentario" rows="4" placeholder="Deixe seu comentário..."></textarea>
        </div>
        <div class="form-group w-50">
            <label for="pontuacao">Pontuação</label>
            <select name="pontuacao" class="form-control" id="selectPontuacao">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    @endif

    <div class="m-4">
    <h4>Comentários e Pontuações</h4>
    @foreach($livro->comentarios as $comentario)
        <div class="comentario">
            <p><strong>{{ $comentario->leitor->nome }}</strong> - Pontuação: {{ $comentario->pontuacao ?? 'Não pontuado' }}</p>
            <p>{{ $comentario->comentario }}</p>

            @if(Auth::check())
                @if(Auth::id() === $comentario->leitor_id)
                    <form action="{{ route('comentario.destroy', $comentario->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Excluir Comentário</button>
                    </form>
                @endif

                @if(Auth::user()->tipoUsuario === 'administrador')
                    <form action="{{ route('comentario.desativar', $comentario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning">Desativar Comentário</button>
                    </form>
                @endif
            @endif
        </div>
    @endforeach 
    </div>

</div>

</div>
</main>

</body>
</html>