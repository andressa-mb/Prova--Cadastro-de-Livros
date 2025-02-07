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
    <div class="alert alert-success alert-container">
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

<div class="m-4 container">
    <h2>Cadastro de Categorias</h2>
    <form action="{{ route('categorias.store') }}" method="POST" id="formCadastroCategorias" enctype="multipart/form-data">
        @csrf
        <div class="form-group w-50">
            <label for="nomeCategoria">Nome da categoria:</label>
            <input class="form-control @error('nome') is-invalid @enderror" id="inputNomeCat" name="nome" placeholder="Aventura" required>
        </div>
        <div class="form-group w-50">
            <label for="descricao">Descrição:</label>
            <input class="form-control @error('descricao') is-invalid @enderror" id="inputDescricao" name="descricao" placeholder="Livros de Aventura...">
        </div>
        <div class="form-group w-50">
            <label for="livrosAssociados" class="form-label">Livros Associados</label>
            <div class="border p-3 rounded">
                @foreach($livros as $livro)
                    <div class="form-check">
                        <input type="checkbox" name="livros[]" value="{{ $livro->id }}" class="form-check-input" id="livro_{{ $livro->id }}">
                        <label class="form-check-label" for="livro_{{ $livro->id }}">{{ $livro->titulo }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" id="btnCadastro" class="btn btn-primary mt-4">Cadastrar</button>
    </form>
</div>

</main>
</body>
</html>