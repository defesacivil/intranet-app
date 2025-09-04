@extends('layouts.app')

@section('content')
<div class="container py-4" id="app">
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-1">Histórico de Posse</h4>
                <p class="text-muted mb-0">Usuario: <strong>{{ $usuarios[0]->nome }}</strong></p>
            </div>
            <a href="{{ route('usuarios.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Movimentações de Manutenção</h6>
        </div>
        <div class="card-body">
            <ul class="timeline list-unstyled">
                <li class="mb-4" v-for="(user, index) in sortedUsuarios" :key="user?.id">
                    <div class="d-flex">
                        <div class="me-3">
                            <span v-if="user.deleted_at === null" class="badge bg-success p-2">Em Posse</span>
                            <span v-else class="badge bg-secondary p-2">Sem Posse</span>
                        </div>
                        <div>
                            <h6 class="mb-1">@{{ user.nome }}</h6>
                            <small class="text-secondary">@{{ formatDate(user.created_at) }}</small>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
.timeline li {
    position: relative;
    padding-left: 20px;
    border-left: 2px solid #dee2e6;
}
.timeline li:last-child {
    border-left: none;
}
</style>

<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            usuarios: @json($usuarios->values())
        };
    },
    computed: {
        sortedUsuarios() {
            return [...this.usuarios].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        }
    },
    methods: {
        formatDate(date) {
            if (!date) return '';
            let d = new Date(date);
            return d.toLocaleString('pt-BR', { timezone: 'UTC' });
        }
    }
}).mount('#app');
</script>
@endsection
