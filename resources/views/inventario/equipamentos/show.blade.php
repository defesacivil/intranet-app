@extends('layouts.app')

@section('title', 'Detalhes do Equipamento')

@section('content')
<div class="container my-5" id="app">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalhes do Equipamento</h4>
        </div>
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $equipamento->nome }}</p>
            <p><strong>Número de Patrimônio:</strong> {{ $equipamento->patrimonio }}</p>
            <p><strong>Categoria:</strong> {{ $equipamento->categoria->nome ?? '-' }}</p>
            <p><strong>Responsável:</strong> {{ $equipamento->responsavel->nome ?? 'Sem Responsável' }}</p>
            <p><strong>Situação:</strong> {{ $equipamento->situacao }}</p>
            <p><strong>Diretoria:</strong> {{ $equipamento->diretoria }}</p>
            <p><strong>Seção/Diretoria:</strong> {{ $equipamento->secao_diretoria }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Registros do Equipamento</h6>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                        + Adicionar
                    </button>
                </div>
                <div class="card-body">
                    @if($equipamento->registros->isEmpty())
                        <p class="text-muted">Nenhum registro encontrado.</p>
                    @else
                        <ul class="list-group">
                            @foreach($equipamento->registros as $registro)
                                <li class="list-group-item">
                                    <strong>[{{ ucfirst($registro->tipo) }}]</strong> - {{ $registro->descricao }} <br>
                                    <small class="text-muted">
                                        Data: {{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y h:m:s') }}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('registros.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="equipamento_id" value="{{ $equipamento->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">Adicionar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Registro</label>
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="manutencao">Manutenção</option>
                        <option value="inspecao">Inspeção</option>
                        <option value="upgrade">Upgrade</option>
                        <option value="baixa">Baixa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection
