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
    <script src="{{ asset('js/autoresEdit.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<header class=" p-4 bg-white shadow-sm">
    <h1>Sistema da Livraria</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Livros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categorias</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Autores<span class="sr-only">(Página atual)</span></a>
                </li>
            </ul>
            <a class="btn btn-primary" href="#" role="button">Login</a>
        </div>
    </nav>
</header>
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
    <h2>Editar Autor</h2>
    
    <form id="formEdit" action="{{ route('autores.update', $autor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group w-50">
            <label for="nome" class="form-label">Nome do autor:</label>
            <input type="text" name="nome" id="inputNome" class="form-control @error('nome') is-invalid @enderror" value="{{ $autor->nome }}" required>
        </div>
        <div class="form-group w-50">
            <label for="labelBio">Biografia</label>
            <textarea class="form-control @error('bio') is-invalid @enderror" id="inputBio" name="bio" rows="4">{{ $autor->bio }}</textarea>
        </div>
        <div class="form-group">
            <input type="file" accept="image/*" name="foto" id="inputFoto" class="@error('foto') is-invalid @enderror">
        </div>
        <div class="form-row">
        @foreach ($autorLinks as $link)
            <div class="form-group col-md-5">
                <label for="labelSite">Nome do Site</label>
                <input type="text" class="form-control @error('site_nome') is-invalid @enderror" name="site_nome[]" id="inputSite" value="{{ $link->site_nome }}">
                <input type="hidden" name="site_id[]" value="{{ $link->id }}">
            </div>
            <div class="form-group col-md-5">
                <label for="labelUrl">URL do site</label>
                <input type="text" class="form-control @error('site_link') is-invalid @enderror" name="site_link[]" id="inputUrl" value="{{ $link->site_link }}">
            </div>
            <div class="form-group col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove" id="btn-remove">X</button>
            </div>
        @endforeach
        </div>
        <input type="hidden" id="removidos" name="removidos" value="">
        <div id="divLinks"></div>

        <div class="mt-3">
            <button type="button" id="addNovo" class="btn btn-primary mt-4 mb-4">Adicionar Link</button>
        </div>

        <button type="submit" class="btn btn-success" id="salvarAutor">Salvar</button>
        <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</main>
</body>
</html>