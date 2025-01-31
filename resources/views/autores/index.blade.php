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
    <header class=" p-4 bg-white shadow-sm">
        <h1>Sistema da Livraria</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
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
        <div class="m-4">  
            <h2>Cadastro de Autores</h2>
            <form action="{{ route('autores.store') }}" method="POST" id="formCadastro" enctype="multipart/form-data">
                @csrf
                <div class="form-group w-50">
                    <label for="labelAutor">Nome do autor(a):</label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="inputAutor" name="nome" placeholder="Clarice Lispector" required>
                </div>
                <div class="form-group w-50">
                    <label for="labelBio">Biografia</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="inputBio" name="bio" rows="4" placeholder="Biografia sobre o autor"></textarea>
                </div>
                <div class="form-group">
                    <input type="file" accept="image/*" name="foto" id="inputFoto" class="@error('foto') is-invalid @enderror">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="labelSite">Nome do Site</label>
                        <input type="text" class="form-control @error('site_nome') is-invalid @enderror" name="site_nome[]" id="inputSite" placeholder="Wikipedia">
                    </div>
                    <div id="linkContainer" class="form-group col-md-6">
                        <label for="labelUrl">URL do site</label>
                        <input type="text" class="form-control @error('site_link') is-invalid @enderror" name="site_link[]" id="inputUrl" placeholder="https://www.wikipedia.org/">
                    </div>
                    <button type="button" id="addLinkBtn" class="btn btn-secondary">Adicionar Link</button>
                    <div id="addedLinks" class="m-4 d-flex"></div>
                </div>

                <button type="submit" id="btnCadastro" class="btn btn-primary mt-4">Cadastrar</button>
            </form>
        </div> 

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
                            <a href="{{ route('autores.destroy', $autor->id) }}" class="btn btn-danger" 
                                onclick="event.preventDefault(); 
                                if (confirm('Você tem certeza que deseja excluir este autor?')) {
                                    document.getElementById('delete-form-{{ $autor->id }}').submit();
                                }">
                                    Excluir
                            </a>
                            <form id="delete-form-{{ $autor->id }}" action="{{ route('autores.destroy', $autor->id) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody> 
        </div>
        <div class="mt-4 d-flex justify-content-center ">
            {{ $autores->links() }}
        </div>
    </main>   

</body>
</html>
