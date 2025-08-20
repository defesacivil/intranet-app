@extends('layouts.app')

@section('title', 'Cadastrar Equipamento')

@section('content')
<div class="container my-5">
    <h2>Cadastrar Novo Equipamento</h2>

    <form action="{{ route('equipamentos.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="patrimonio" class="form-label">Número de Patrimônio</label>
            <input type="number" name="patrimonio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoria</label>
            <select name="categoria_id" class="form-select" required>
                @foreach($categorias as $key => $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Responsável</label>
            <select name="user_id" class="form-select js-example-basic-single" required>
                <option value=""></option>    
                @foreach($usuarios as $key => $usuario)
                    <option value="{{ $usuario['id_usuario'] }}">{{ $usuario['nome'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="situacao" class="form-label">Situação</label>
            <select name="situacao" class="form-select">
                <option value="Disponível">Disponível</option>                                                                                                                                                                                                                                                                                                                                                                                                                                                                       lect" required>
                <option value="Em uso">Em uso</option>
                <option value="Manutenção">Manutenção</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="diretoria" class="form-label">Diretoria</label>
            <input type="text" name="diretoria" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="secao_diretoria" class="form-label">Seção/Diretoria</label>
            <input type="text" name="secao_diretoria" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
