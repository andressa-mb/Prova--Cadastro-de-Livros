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
    <h2>Editar Livro</h2>
    <form id="formEdit" action="{{ route('livros.update', $livros->id) }}" method="POST" enctype="multipart/form-data">
        @csrf    
        @method('PUT')
        <div class="form-group">
            <input type="file" accept="image/*" name="capa" id="inputCapa" class="@error('capa') is-invalid @enderror">
        </div>
        <div class="form-group w-50">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" name="titulo" id="inputTitulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ $livros->titulo }}" required>
        </div>
        <div class="form-group w-50">
            <label for="editora">Editora:</label>
            <input type="text" name="editora" id="inputEditora" class="form-control @error('editora') is-invalid @enderror" value="{{ $livros->editora }}" required>
        </div>
        <div class="form-group w-50">
            <label for="data">Data de publicação:</label>
            <input type="date" name="data_publicacao" id="inputData" class="form-control @error('data_publicacao') is-invalid @enderror" value="{{ $livros->data_publicacao }}" required>
        </div>
        <div class="form-group w-50">
            <label for="keywords">Keywords:</label>
            <input type="text" name="keywords" id="inputKeywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ $livros->keywords }}">
        </div>
        <div class="form-group w-50">
            <label for="autoresAssociados" class="form-label">Autores:</label>
            <div class="border p-3 rounded">
                @foreach($autores as $autor)
                    <div class="form-check">
                        <input type="checkbox" name="autor[]" value="{{ $autor->id }}" class="form-check-input" id="autor_{{ $autor->id }}"
                        @if(in_array($autor->id, $livros->autores->pluck('id')->toArray())) checked @endif>
                        <label class="form-check-label" for="autor_{{ $autor->id }}">{{ $autor->nome }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group w-50">
            <label for="categoriasAssociados" class="form-label">Categorias:</label>
            <div class="border p-3 rounded">
                @foreach($categorias as $categoria)
                    <div class="form-check">
                        <input type="checkbox" name="categoria[]" value="{{ $categoria->id }}" class="form-check-input" id="categoria_{{ $categoria->id }}"
                        @if(in_array($categoria->id, $livros->categorias->pluck('id')->toArray())) checked @endif>
                        <label class="form-check-label" for="categoria_{{ $categoria->id }}">{{ $categoria->nome }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-success" id="salvarLivro">Salvar</button>
        <a href="{{ route('livros.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</main>
</body>
</html>