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

    <div>COMENTÁRIOS SERÃO AQUI</div>
</div>
</main>

</body>
</html>