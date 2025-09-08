@extends('layouts.app')

@section('title', 'Editar Equipamento')

@section('content')
<div class="container my-5" id="app" v-cloak>
    <h2>Editar Equipamento</h2>

    <form action="{{ route('categorias.update', ['categoria' => $categoria->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da Categoria</label>
            <input type="text" name="nome" value="{{ $categoria->nome }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
