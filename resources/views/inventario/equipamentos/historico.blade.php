@extends('layouts.app')

@section('content')
<div class="container py-4" id="app">
    <!-- Cabeçalho -->
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-1">Histórico de Posse</h4>
                <p class="text-muted mb-0">Equipamento: <strong>{{ $equipamentos[0]->nome }}</strong></p>
                <p class="text-muted mb-0">Patrimônio: <strong>{{ $equipamentos[0]->patrimonio }}</strong></p>
            </div>
            <a href="{{ route('equipamentos.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Linha do tempo -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Movimentações de Posse</h6>
        </div>
        <div class="card-body">
            <ul class="timeline list-unstyled">
                <li class="mb-4" v-for="(equip, index) in sortedEquipamentos" :key="equip?.id">
                    <div class="d-flex">
                        <div class="me-3">
                            <!-- Só mostra "Atual" no mais recente -->
                            <span v-if="index === 0" class="badge bg-success p-2">Atual</span>
                            <span v-else class="badge bg-secondary p-2">Anterior</span>
                        </div>
                        <div>
                            <h6 class="mb-1">@{{ equip.user_id }}</h6>
                            <p class="mb-1 text-muted">Seção/Diretoria: @{{ equip.secao_diretoria }}</p>
                            <small class="text-secondary">@{{ formatDate(equip.created_at) }}</small>
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
            equipamentos: @json($equipamentos->values())
        };
    },
    computed: {
        // Ordena desc pela data (mais recente primeiro)
        sortedEquipamentos() {
            return [...this.equipamentos].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        }
    },
    methods: {
        formatDate(date) {
            if (!date) return '';
            let d = new Date(date);
            return d.toLocaleDateString('pt-BR'); // dd/mm/yyyy
        }
    }
}).mount('#app');
</script>
@endsection
