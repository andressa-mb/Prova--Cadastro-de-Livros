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
<div class="container">
    <div id="autor">
        <h1 class="text-center">{{ $autor->nome }}</h1>
        <img src="{{ $autor->foto && Storage::exists('public/' . $autor->foto) ? asset('storage/'. $autor->foto) : asset('imagens/avatar.jpg') }}" alt='Foto Autor' width="80" class="rounded mx-auto d-block"> 
    </div>
    <div id="bio">
        <h4>Biografia:</h4>
        <p>{{ $autor-> bio }}</p>
    </div>
    <div id="links">
        <h4>Links:</h4>        
        @if($autor->links->isNotEmpty())
            @foreach($autor->links as $link)
            <ul class="list-group table-hover w-25">
                <li class="list-group-item "><a href="{{ $link->site_link }}" target="_blank" class="d-block text-truncate" style="max-width: 150px;">{{ $link->site_nome }}</a></li>
            </ul>
            @endforeach
        @else
            <p>Nenhum site disponível.</p>
        @endif
    </div>
    <div id="livros" class="mt-4">
    <table class="table">
        <thead class="table-info">
            <tr>
                <th scope="col">Título</th>
                <th scope="col">Categorias</th>
                <th scope="col">Editora</th>
                <th scope="col">Publicação</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($autor->livros as $livro)
            <tr>
                <td>{{ $livro->titulo }}</td>
                <td>
                    @foreach($livro->categorias as $categoria)
                        {{ $categoria->nome }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>{{ $livro->editora }}</td>
                <td>{{ $livro->data_publicacao }}</td>
                <td>
                    <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-primary m-2">Exibir</a> 
                </td>
            </tr>
            @endforeach
        </tbody> 
    </div>
</div>
</main>

</body>
</html>