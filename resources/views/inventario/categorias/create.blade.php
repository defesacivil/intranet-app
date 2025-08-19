@extends('layouts.app')

@section('title', 'Cadastrar Categoria')

@section('content')
<div class="container my-5">
    <h2>Cadastrar Nova Categoria</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Categoria</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
