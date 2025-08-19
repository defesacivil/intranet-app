@extends('layouts.app')

@section('title', 'Cadastrar Equipamento')

@section('content')
<div class="container my-5">
    <h2>Editar Equipamento</h2>

    <form action="{{ route('equipamentos.update', ['equipamento' => $equipamento->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ $equipamento->nome }}" required>
        </div>

        <div class="mb-3">
            <label for="patrimonio" class="form-label">Número de Patrimônio</label>
            <input type="text" name="patrimonio" class="form-control" value="{{ $equipamento->nome }}" required>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select name="categoria" class="form-select" required>
                @foreach($categorias as $key => $categoria)
                    <option value="{{ $categoria->id }}" {{ $categoria->id == $equipamento->categoria_id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="responsavel" class="form-label">Responsável</label>
            <input type="text" name="responsavel" class="form-control" value="{{ $equipamento->responsavel }}" required>
        </div>

        <div class="mb-3">
            <label for="situacao" class="form-label">Situação</label>
            <select name="situacao" class="form-select"                                                                                                                                                                                                                                                                                                                                                                                                                                                                       lect" required>
                <option value="Em uso" {{ $equipamento->situacao == "Em uso" ? 'selected' : '' }}>Em uso</option>
                <option value="Manutenção" {{ $equipamento->situacao == "Manutenção" ? 'selected' : '' }}>Manutenção</option>
                <option value="Disponível" {{ $equipamento->situacao == "Disponível" ? 'selected' : '' }}>Disponível</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="diretoria" class="form-label">Diretoria</label>
            <input type="text" name="diretoria" class="form-control" value="{{ $equipamento->diretoria }}" required>
        </div>

        <div class="mb-3">
            <label for="secao_diretoria" class="form-label">Seção/Diretoria</label>
            <input type="text" name="secao_diretoria" class="form-control" value="{{ $equipamento->secao_diretoria }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
