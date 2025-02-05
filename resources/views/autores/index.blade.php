<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Livraria</title>
    <script src="{{ asset('js/autores.js') }}" defer></script>
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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="listaAutores" class="mt-4 table-responsive-lg">       
    <h2>Lista de Autores</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Biografia</th>
                <th scope="col">Livros</th>
                <th scope="col">Site(s)</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($autores as $autor)
            <tr>
                <td><img src="{{ $autor->foto ? asset('storage/'. $autor->foto) : asset('imagens/avatar.jpg') }}" alt='Foto Autor' width="80"></td>
                <td>{{ $autor->nome }}</td>
                <td>{{ $autor->bio }}</td>

                <td>{{ $autor->livros_count }}</td>

                <td class="d-flex flex-column">
                    @if($autor->links->isNotEmpty())
                        @foreach($autor->links as $link)
                            <a href="{{ $link->site_link }}" target="_blank" class="d-block text-truncate" style="max-width: 150px;">{{ $link->site_nome }}</a>
                        @endforeach
                    @else
                        Nenhum site disponível.
                    @endif
                </td>

                <td>
                    <a href="{{ route('autores.show', $autor->id) }}" class="btn btn-primary m-2">Exibir</a> 
        <!--        @if(auth()->user() && auth()->user()->is_admin) @endif -->
                    <a href="{{ route('autores.edit', $autor->id) }}" class="btn btn-warning m-2">Editar</a> 

                    <a class="btn btn-danger" data-toggle="modal" data-target="#modalExcluir" data-id="{{ $autor->id }}" data-nome="{{ $autor->nome }}" data-route="{{ route('autores.destroy', $autor-> id) }}" >Excluir</a>

                </td>
            </tr>
            @endforeach
        </tbody> 
</div>
<div class="mt-4 d-flex justify-content-center ">
    {{ $autores->links() }}
</div>

<!-- MODAL -->
<div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="modalExcluir" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Excluir Autor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir o(a) autor(a) <span id="autorNome">?</p>
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
