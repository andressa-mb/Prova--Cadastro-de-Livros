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
<div id="categoria" class="container">
    <h1 class="text-center">{{ $categoria->nome }}</h1>
    <div>
        <h4>Descrição</h4>

        @if($categoria->descricao)
            <p>{{ $categoria->descricao }}</p>
        @else 
            <p>Não há descrição para essa categoria.</p>
        @endif
    </div>
    <div>
        <h4>Livros Associados</h4>
        @if($categoria->livros->isNotEmpty())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor(es)</th>
                    <th>Categoria(s)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($livros as $livro)
                    <tr>
                        <td>{{ $livro->titulo }}</td>
                        <td>
                            @foreach($livro->autores as $autor)
                                <span>{{ $autor->nome }}</span>
                                @if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($livro->categorias as $cat)
                                <span>{{ $cat->nome }}</span>
                                @if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-primary">Ver Livro</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $livros->links() }}
        </div>
        @else
            <p>Nenhum livro associado a esta categoria.</p>
        @endif
    </div>
    
</div>

</main>
</body>
</html>