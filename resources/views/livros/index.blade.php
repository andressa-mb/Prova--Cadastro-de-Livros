<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Livraria</title>
    <script src="{{ asset('js/livros.js') }}" defer></script>
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

    <div id="listaLivros" class="mt-4 table-responsive-lg container">  
        <form method="GET" action="{{ route('livros.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar por título, editora, autor ou categoria" value="{{ request('pesquisar') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
        </form>     
        <h2>Lista de Livros</h2>
        @if($livros->count())
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Capa</th>
                    <th scope="col">Título</th>
                    <th scope="col">Editora</th>
                    <th scope="col">Data de publicação</th>
                    <th scope="col">Keywords</th>
                    <th scope="col">Autores</th>
                    <th scope="col">Categorias</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($livros as $livro)
                <tr>
                    <td><img src="{{ $livro->capa ? asset('storage/'. $livro->capa) : asset('imagens/capa.png') }}" alt='Capa' width="80"></td>
                    <td>{{ $livro->titulo }}</td>
                    <td>{{ $livro->editora }}</td>
                    <td>{{ $livro->data_publicacao }}</td>
                    <td>{{ $livro->keywords }}</td>

                    <td>
                        @if($livro->autores->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach($livro->autores as $autor)
                                    <li>{{ $autor->nome }}</li>
                                @endforeach
                            </ul>
                        @else
                            Nenhum autor associado.
                        @endif
                    </td>
                    <td>
                        @if($livro->categorias->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach($livro->categorias as $categoria)
                                    <li>{{ $categoria->nome }}</li>
                                @endforeach
                            </ul>
                        @else
                            Nenhuma categoria associada.
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('livros.show', $livro->id) }}" class="btn btn-primary m-2">Exibir</a> 
            <!--        @if(auth()->user() && auth()->user()->is_admin) @endif -->
                        <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-warning m-2">Editar</a> 

                        <a class="btn btn-danger" data-toggle="modal" data-target="#modalExcluir" data-id="{{ $livro->id }}" data-nome="{{ $livro->titulo }}" data-route="{{ route('livros.destroy', $livro-> id) }}" >Excluir</a>

                    </td>
                </tr>
                @endforeach
            </tbody> 
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $livros->links() }}
    </div>
    @else
        <p class="text-muted">Nenhum livro encontrado.</p>
    @endif
    <!-- MODAL -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="modalExcluir" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Excluir Livro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir o livro <span id="titulo">?</p>
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
