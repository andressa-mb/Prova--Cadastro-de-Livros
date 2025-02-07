<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Livraria</title>
    <script src="{{ asset('js/categorias.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@include('header')

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

        <div>
            <a class="btn btn-danger" data-toggle="modal" data-target="#modalExcluir" data-id="{{ $categoria->id }}" data-nome="{{ $categoria->nome }}" data-route="{{ route('categorias.destroy', $categoria-> id) }}">Excluir Categoria</a>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="modalExcluir" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Excluir Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir esta categoria <span id="nomeCat">?</p>
                <form action="" method="POST" id="formExcluir">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="confirmeExcluir">Excluir</button>
            </div>
        </div>
    </div>
</div>

</main>
</body>
</html>