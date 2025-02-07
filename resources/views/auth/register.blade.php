@include('header')
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Cadastro</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="mb-3">                
                <input type="text" name="nome" placeholder="Digite seu nome" required>
        </div>
        <div class="mb-3">                
            <input type="email" name="email" placeholder="Digite seu email" required>                
        </div>
        <div class="mb-3">                
            <input type="password" name="password" placeholder="Digite sua senha" required  value="{{ old('password') }}">                
        </div>
        <div class="mb-3">                
            <input type="password" name="password_confirmation" placeholder="Confirme sua senha" required  value="{{ old('password_confirmation') }}">              
        </div>
        <button type="submit">Registrar</button>
    </form>
    <a href="{{ route('login') }}">Já tem conta? Faça login</a>
 </div>