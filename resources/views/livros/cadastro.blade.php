<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Livraria</title>
    <script src="{{ asset('js/livros.js') }}" defer></script>
    <script src="{{ asset('js/autores.js') }}" defer></script>
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

<div class="container">  
    <h2>Cadastro de Livros</h2>
    <form action="{{ route('livros.store') }}" method="POST" id="formCadastroLivros" enctype="multipart/form-data">
        @csrf
        <div class="form-group w-50">
            <label for="labelTitulo">Título:</label>
            <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="inputTitulo" name="titulo" placeholder="A marca de uma lágrima" required>
        </div>
        <div class="form-group w-50">
            <label for="labelEditora">Editora</label>
            <input class="form-control @error('editora') is-invalid @enderror" id="inputEditora" name="editora" placeholder="Moderna" required>
        </div>
        <div class="form-group">
            <input type="file" accept="image/*" name="capa" id="inputCapa" class="@error('capa') is-invalid @enderror">
        </div>
        <div class="form-group w-50">
            <label for="labelDataPubli">Data de publicação</label>
            <input type="date" class="form-control @error('data_publicacao') is-invalid @enderror" id="inputDataPubli" name="data_publicacao" placeholder="20/01/2025" required>
        </div>
        <div class="form-group w-50">
            <label for="labelKeywords">Keywords</label>
            <input class="form-control @error('keywords') is-invalid @enderror" id="inputKeywords" name="keywords" placeholder="Emocionante">
        </div>
        <div class="form-group w-50">
            <label for="autor" class="form-label">Selecione o(s) Autor(es)</label>
            <button type="button" class="btn btn-sm btn-success my-2 d-block" data-toggle="modal" data-target="#modalAutor">
                + Adicionar Autor
            </button>
            <div class="border p-3 rounded">
                @foreach($autores as $autor)
                    <div class="form-check">
                        <input type="checkbox" name="autor[]" value="{{ $autor->id }}" class="form-check-input" id="autor_{{ $autor->id }}">
                        <label class="form-check-label" for="categoria_{{ $autor->id }}">{{ $autor->nome }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group w-50">
            <label for="categoria" class="form-label">Selecione a(s) Categoria(s)</label>
            <button type="button" class="btn btn-sm btn-success my-2 d-block" data-toggle="modal" data-target="#modalCategoria">
                + Adicionar Categoria
            </button>           
            <div class="border p-3 rounded">
                @foreach($categorias as $categoria)
                    <div class="form-check">
                        <input type="checkbox" name="categoria[]" value="{{ $categoria->id }}" class="form-check-input" id="categoria_{{ $categoria->id }}">
                        <label class="form-check-label" for="categoria_{{ $categoria->id }}">{{ $categoria->nome }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" id="btnCadastro" class="btn btn-primary mt-4">Cadastrar</button>
    </form>
</div>
<!--  MODAL AUTOR -->
<div class="modal fade" id="modalAutor" tabindex="-1" aria-labelledby="modalAutorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAutorLabel">Novo Autor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route ('autores.store')}}" method="POST" id="formCadastroAutor" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modal" value="true">
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
                        <button type="button" id="addLinkBtn" class="btn btn-secondary my-2">Adicionar Link</button>
                        <div id="addedLinks" class="m-4 d-flex"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Autor</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- MODAL CATEGORIA -->

<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCategoriaLabel">Nova Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('categorias.store')}}" method="POST" id="formCadastroCategoria">
                    @csrf
                    <input type="hidden" name="modal" value="true">
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
                    <button type="submit" class="btn btn-primary">Salvar Categoria</button>
                </form>
            </div>
        </div>
    </div>
</div>

</main>
</body>
</html>