@extends('layouts.app')

@section('content')
<div class="container my-5" id="app" v-cloak>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-tags"></i> Categorias</h4>
            <a href="{{ route('categorias.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus-circle"></i> Nova Categoria
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
                        <tr v-for="cat in filteredCategorias" :key="cat?.id">
                            <td v-for="dado in impressaoModelo" class="text-center align-middle">
                                <template v-if="dado !== 'Ações'">
                                    @{{ impressaoDados[dado](cat) }}
                                </template>
                                <template v-else>
                                    <a :href="`/categorias/${cat.id}/edit`" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" @click="deleteCategoria(cat.id)">
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
            'Criado em',
            'Ações'
        ];

        const impressaoDados = {
            'Nome': c => c.nome ?? '',
            'Descrição': c => c.descricao ?? '',
            'Criado em': c => new Date(c.created_at).toLocaleDateString('pt-BR') ?? ''
        };

        return {
            impressaoModelo,
            impressaoDados,
            search: '',
            categorias: @json($categorias->values())
        };
    },
    computed: {
        filteredCategorias() {
            if (!this.search) return this.categorias;
            let term = this.search.toLowerCase();
            return this.categorias.filter(c =>
                c?.nome?.toLowerCase().includes(term) ||
                c?.descricao?.toLowerCase().includes(term)
            );
        }
    },
    methods: {
        async deleteCategoria(id) {
            if (!confirm('Tem certeza que deseja excluir esta categoria?')) return;
            const formData = new FormData();
            formData.append('_method', 'DELETE');

            await fetch(`/categorias/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            this.categorias = this.categorias.filter(c => c?.id !== id);
        }
    }
}).mount('#app');
</script>
@endsection
