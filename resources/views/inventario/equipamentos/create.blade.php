@extends('layouts.app')

@section('title', 'Cadastrar Equipamento')

@section('content')
<div class="container my-5" id="app">
    <h2>Cadastrar Novo Equipamento</h2>

    <form action="{{ route('equipamentos.store') }}" method="POST" @submit.prevent="submitForm">
        @csrf
        @method('POST')

        <!-- Nome -->
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" v-model="form.nome" class="form-control" required>
        </div>

        <!-- Patrimônio -->
        <div class="mb-3">
            <label for="patrimonio" class="form-label">Número de Patrimônio</label>
            <input type="number" name="patrimonio" v-model="form.patrimonio" class="form-control" required>
        </div>

        <!-- Categoria -->
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoria</label>
            <select name="categoria_id" v-model="form.categoria_id" class="form-select" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Responsável -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Responsável</label>
            <select name="user_id" id="user_id" class="form-select js-example-basic-single">
                <option value=""></option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario['id_usuario'] }}">{{ $usuario['nome'] }}</option>
                @endforeach
            </select>
        </div>

        <!-- Situação -->
        <div class="mb-3">
            <label for="situacao" class="form-label">Situação</label>
            <input type="text" name="situacao" v-model="situacao" class="form-control" readonly>
        </div>

        <!-- Diretoria -->
        <div class="mb-3">
            <label for="diretoria" class="form-label">Diretoria</label>
            <input type="text" name="diretoria" v-model="form.diretoria" class="form-control" required>
        </div>

        <!-- Seção/Diretoria -->
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
                nome: '',
                patrimonio: '',
                categoria_id: '',
                user_id: '',
                diretoria: '',
                secao_diretoria: ''
            },
            situacao: 'Disponível'
        },
        mounted() {
            this.$nextTick(() => {
                $('.js-example-basic-single').select2();
            });
        },
        methods: {
            atualizarSituacao() {
                this.situacao = this.form.user_id ? 'Em uso' : 'Disponível';
            },
            submitForm() {
                // Atualiza input hidden antes de enviar
                this.$el.querySelector('input[name="situacao"]').value = this.situacao;
                this.$el.querySelector('form').submit();
            }
        }
    });

    $('#user_id').select2().on('change', function() {
        vm.form.user_id = $(this).val();
        vm.atualizarSituacao();
    });
});
</script>
@endsection
