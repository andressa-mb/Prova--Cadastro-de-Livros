@include('header')
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Lista de Administradores</h2>
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

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->nome }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar{{ $admin->id }}">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalExcluir{{ $admin->id }}">Excluir</a>
                    
                    </td>
                </tr>
                <div class="modal fade" id="modalEditar{{ $admin->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditar{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Administrador</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $admin->nome) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalExcluir{{ $admin->id }}" tabindex="-1" role="dialog" aria-labelledby="modalExcluir{{ $admin->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Excluir Administrador</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Deseja realmente excluir o administrador <strong>{{ $admin->nome }}</strong>?</p>
                                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" id="formExcluir{{ $admin->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection