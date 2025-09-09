@extends('layouts.app')

@section('content')
<div class="container my-5" id="app" v-cloak>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-boxes"></i> Equipamentos</h4>
            <a href="{{ route('equipamentos.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Novo Equipamento
            </a>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Buscar por nome" v-model="search">
            </div>
            <div class="table-responsive" style="max-height: 500px;">
                <table v-if="impressaoModelo.length" class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th v-for="dado in impressaoModelo" class="text-center">
                                @{{ dado }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="equip in filteredEquipamentos" :key="equip?.id">
                            <td v-for="dado in impressaoModelo" class="text-center align-middle">
                                <template v-if="dado !== 'Ações'">
                                    @{{ impressaoDados[dado](equip) }}
                                </template>
                                <template v-else>
                                    <a :href="`/equipamentos/${equip.id}/historico
                                    
                                    `" class="btn btn-sm btn-outline-warning me-1">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    <a :href="`/equipamentos/${equip.id}/show
                                    `" class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a :href="`/equipamentos/${equip.id}/edit`" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" @click="deleteEquipamento(equip.id)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
const { createApp } = Vue;
createApp({
    data() {
        const impressaoModelo = [
            'Nome',
            'Patrimônio',
            'Categoria',
            'Responsável',
            'Situação',
            'Diretoria',
            'Seção/Diretoria',
            'Ações'
        ];
        const impressaoDados = {
            'Nome': e => e.nome ?? '',
            'Patrimônio': e => e.patrimonio ?? '',
            'Categoria': e => e.categoria?.nome ?? '',
            'Responsável': e => e.responsavel ?? '',
            'Situação': e => e.situacao ?? '',
            'Diretoria': e => e.diretoria ?? '',
            'Seção/Diretoria': e => e.secao_diretoria ?? ''
        };
        return {
            impressaoModelo,
            impressaoDados,
            search: '',
            equipamentos: @json($equipamentos->values())
        };
    },
    computed: {
        filteredEquipamentos() {
            if (!this.search) return this.equipamentos;
            let term = this.search.toLowerCase();
            return this.equipamentos.filter(e =>
                e?.nome?.toLowerCase().includes(term) ||
                e?.patrimonio?.toLowerCase().includes(term)
            );
        }
    },
    methods: {
        async deleteEquipamento(id) {
            if (!confirm('Tem certeza que deseja excluir?')) return;
            const formData = new FormData();
            formData.append('_method', 'DELETE');

            await fetch(`/equipamentos/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            this.equipamentos = this.equipamentos.filter(e => e?.id !== id);
        }
    }
}).mount('#app');
</script>
@endsection
