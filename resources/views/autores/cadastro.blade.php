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
@extends('layouts.app')
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
<div class="container">  
    <h2>Cadastro de Autores</h2>
    <form action="{{ route('autores.store') }}" method="POST" id="formCadastroAutor" enctype="multipart/form-data">
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
</main>
</body>
</html>