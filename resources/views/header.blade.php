<header class=" p-4 bg-white shadow-sm">
    <h1>Sistema da Livraria</h1>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('livros*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Livros</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('livros.index') }}">Lista de Livros</a>
                        <a class="dropdown-item" href="{{ route('livros.cadastro') }}">Cadastro de Livros</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('categorias*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categorias</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Lista de Cadastro</a>
                        <a class="dropdown-item" href="#">Cadastro de Categorias</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('autores*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Autores</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('autores.index') }}">Lista de Autores</a>
                        <a class="dropdown-item" href="{{ route('autores.cadastro') }}">Cadastro de Autores</a>
                    </div>
                </li>
            </ul>
            <a class="btn btn-primary" href="#" role="button">Login</a>
        </div>
    </nav>
</header>