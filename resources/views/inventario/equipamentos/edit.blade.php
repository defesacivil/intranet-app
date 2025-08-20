@extends('layouts.app')

@section('title', 'Editar Equipamento')

@section('content')
<div class="container my-5" id="app">
    <h2>Editar Equipamento</h2>

    <form action="{{ route('equipamentos.update', ['equipamento' => $equipamento->id]) }}" method="POST" @submit.prevent="submitForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" v-model="form.nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="patrimonio" class="form-label">Número de Patrimônio</label>
            <input type="text" name="patrimonio" v-model="form.patrimonio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoria</label>
            <select name="categoria_id" v-model="form.categoria_id" class="form-select" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Responsável</label>
            <select name="user_id" id="user_id" class="form-select js-example-basic-single">
                <option value="">Sem Responsavel</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario['id_usuario'] }}">{{ $usuario['nome'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="situacao" class="form-label">Situação</label>
            <input type="text" name="situacao" v-model="situacao" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="diretoria" class="form-label">Diretoria</label>
            <input type="text" name="diretoria" v-model="form.diretoria" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="secao_diretoria" class="form-label">Seção/Diretoria</label>
            <input type="text" name="secao_diretoria" v-model="form.secao_diretoria" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
$(document).ready(function() {
    const vm = new Vue({
        el: '#app',
        data: {
            form: {
                nome: '{{ $equipamento->nome }}',
                patrimonio: '{{ $equipamento->patrimonio }}',
                categoria_id: '{{ $equipamento->categoria_id }}',
                user_id: '{{ $equipamento->user_id ?? "" }}',
                diretoria: '{{ $equipamento->diretoria }}',
                secao_diretoria: '{{ $equipamento->secao_diretoria }}'
            },
            situacao: '{{ $equipamento->situacao }}'
        },
        methods: {
            atualizarSituacao() {
                this.situacao = this.form.user_id ? 'Em uso' : 'Disponível';
            },
            submitForm() {
                this.$el.querySelector('input[name="situacao"]').value = this.situacao;
                this.$el.querySelector('form').submit();
            }
        }
    });

    $('#user_id').val(vm.form.user_id).trigger('change');
    $('#user_id').select2({
        theme: "bootstrap-5", 
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    }).on('change', function() {
        vm.form.user_id = $(this).val();
        vm.atualizarSituacao();
    });

    vm.atualizarSituacao();
});
</script>
@endsection
