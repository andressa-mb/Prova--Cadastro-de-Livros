<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
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
<!-- @if(Auth::check() && Auth::user()->role === 'admin')  @endif --> 
@section('content')

<!-- Exibir mensagem de sucesso após cadastro -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
        <div class="m-4">  
            <h2>Cadastro de Autores</h2>
            <form action="/autores" method="POST" id="formCadastro">
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
                    <div id="addedLinks" class="ml-4 mr-4 d-flex"></div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">Lembrar de mim</label>
                    </div>
                </div>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" id="btnCadastro" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
 

    </main>

<script>
    document.getElementById('addLinkBtn').addEventListener('click', function() {
        var siteName = document.getElementById('inputSite').value;
        var siteLink = document.getElementById('inputUrl').value;
        
        if (siteName && siteLink) {
            var addedLinksDiv = document.getElementById('addedLinks');
            
            var linkItem = document.createElement('div');
            linkItem.classList.add('link_item');
            linkItem.innerHTML = `
                <span class="ml-4" >${siteName} - <a href="${siteLink}" target="_blank">${siteLink}</a></span>
                <button type="button" class="btn btn-danger btn-sm remove-link">X</button>
                <input type="hidden" name="site-nome[]" value="${siteName}">
                <input type="hidden" name="site-link[]" value="${siteLink}">
            `;
            
            addedLinksDiv.appendChild(linkItem);

            document.getElementById('inputSite').value = '';
            document.getElementById('inputUrl').value = '';
        } else {
            alert('Preencha tanto o Nome do Site quanto a URL!');
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-link')) {
            e.target.parentNode.remove();
        }
    });
</script>
</body>
</html>
