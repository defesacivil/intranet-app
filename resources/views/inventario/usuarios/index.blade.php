@extends('layouts.app')

@section('content')
<div class="container my-5" id="app" v-cloak>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Buscar por nome ou email" v-model="search">
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
                        <tr v-for="user in filteredUsers" :key="user?.id_usuario">
                            <td v-for="dado in impressaoModelo" class="text-center align-middle">
                                <template v-if="dado !== 'Ações'">
                                    @{{ impressaoDados[dado](user) }}
                                </template>
                                <template v-else>
                                    <a :href="`/usuarios/${user.id_usuario}/historico
                                    `" class="btn btn-sm btn-outline-warning me-1">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    <a :href="`/usuarios/${user.id_usuario}/edit`" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
            'Ações'
        ];

        const impressaoDados = {
            'Nome': u => u.nome ?? '',
        };

        return {
            impressaoModelo,
            impressaoDados,
            search: '',
            users: @json($users)
        };
    },
    computed: {
        filteredUsers() {
            if (!this.search) return this.users;
            let term = this.search.toLowerCase();
            return this.users.filter(u =>
                u?.name?.toLowerCase().includes(term) ||
                u?.email?.toLowerCase().includes(term)
            );
        }
    }
}).mount('#app');
</script>
@endsection
