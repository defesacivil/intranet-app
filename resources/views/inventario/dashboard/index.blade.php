@extends('layouts.app')

@section('content')
<div class="container my-4" id="app" v-cloak>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <h6>Total de materiais</h6>
                    <h3>@{{ (totaisEquipamentos[0]?.count || 0) + (totaisEquipamentos[1]?.count || 0) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <h6>Materiais em posse</h6>
                    <h3>@{{ totaisEquipamentos[0]?.count || 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <h6>Materiais disponíveis</h6>
                    <h3>@{{ totaisEquipamentos[1]?.count || 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Disponibilidade/Posse</h6>
                    <apexchart class="chart" 
                               :options="optionsTotalPorSituacao" 
                               :series="seriesTotalPorSituacao" 
                               type="donut">
                    </apexchart>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6>Distribuição por Categoria</h6>
                    <apexchart class="chart" 
                               :options="optionsTotalPorCategoria" 
                               :series="seriesTotalPorCategoria" 
                               type="donut">
                    </apexchart>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-6"> 
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-boxes"></i>Ver Equipamentos</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 500px;">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar por nome" v-model="search">
                    </div>
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th v-for="(dado, index) in impressaoModelo" :key="index" class="text-center">
                                    @{{ dado }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="filteredEquipamentos.length === 0">
                                <td colspan="2" class="text-center">Nenhum material encontrado.</td>
                            </tr>
                            <tr v-for="equip in filteredEquipamentos" :key="equip?.id_usuario">
                                <td v-for="(columnTitle, colIndex) in impressaoModelo" :key="colIndex" class="text-center align-middle">
                                    <template v-if="columnTitle !== 'Ações'">
                                        @{{ impressaoDados[columnTitle] ? impressaoDados[columnTitle](equip) : (equip[columnTitle.toLowerCase()] ?? '') }}
                                    </template>
                                    <template v-else>
                                        <a class="btn btn-sm btn-info me-1" :href="`/usuarios/${equip.id_usuario}/show`">
                                            <i class="fas fa-eye"></i>
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
        <div class="col-md-6"> 
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-boxes"></i> Quantidades por categoria</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 500px;">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar por nome" v-model="searchCategoria">
                    </div>
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                              <td>Categoria</td>
                              <td>Quantidade</td>
                            </tr>
                        </thead>
                        <tbody>
                          <tr v-for="cat in totaisPorCategoria" :key="cat.categoria_id">
                              <td>@{{ cat.nome }}</td>
                              <td>@{{ cat.count }}</td>
                          </tr>
                      </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3.2.45/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/vue3-apexcharts"></script>

<script>
    const { createApp } = Vue;

    const totaisEquipamentos = @json($totaisEquipamentos->values() ?? []);
    const totaisPorCategoria = @json($totalPorCategorias->values() ?? []);
    const equipamentosData = @json($usuarios['data'] ?? []); 

    createApp({
        components: {
            apexchart: VueApexCharts
        },
        data() {
          console.log('Totais por categoria:', totaisPorCategoria);
            const impressaoModelo = [
                'Usuário',
                'Ações',
            ];
            
            const impressaoDados = {
                'Usuário': equip => equip.nome ?? 'Nome Indisponível',
            };

            const impressaoModeloCategorias = [
                'Nome',
                'Quantidade',
            ];

            const impressaoDadosCategoria = {
                'Nome': cat => cat.nome ?? 'Categoria Indisponível',
                'Quantidade': cat => cat.count ?? '—',
            };

            return {
                totaisEquipamentos: Array.isArray(totaisEquipamentos) ? totaisEquipamentos : [],
                totaisPorCategoria: Array.isArray(totaisPorCategoria) ? totaisPorCategoria : [],
                
                impressaoModelo,
                impressaoDados, 
                
                usuarios: equipamentosData,
                search: '', 

                optionsTotalPorSituacao: {
                    chart: { type: 'donut', toolbar: { show: false } },
                    labels: ['Disponíveis', 'Em Posse'],
                    responsive: [{
                        breakpoint: 1000,
                        options: {
                            chart: { width: '100%' },
                            legend: { position: 'bottom' }
                        }
                    }]
                },
                optionsTotalPorCategoria: {
                    chart: { type: 'donut', toolbar: { show: false } },
                    labels: (totaisPorCategoria || []).map(c => c.nome ?? '—'),
                    responsive: [{
                        breakpoint: 1000,
                        options: {
                            chart: { width: '100%' },
                            legend: { position: 'bottom' }
                        }
                    }]
                }
            };
        },
        computed: {
            filteredEquipamentos() {
                if (!this.search) {
                    return this.usuarios;
                }
                const searchTerm = this.search.toLowerCase();
                return this.usuarios.filter(usuario => {
                    return usuario.nome.toLowerCase().includes(searchTerm);
                });
            },
            filteredCategorias() {
                if (!this.searchCategoria) return this.totaisPorCategoria;

                return this.totaisPorCategoria.filter(cat =>
                    cat.nome.toLowerCase().includes(this.searchCategoria.toLowerCase())
                );
            },
            seriesTotalPorSituacao() {
                const emPosse = this.totaisEquipamentos[1]?.count || 0;
                const disponiveis = this.totaisEquipamentos[0]?.count || 0;
                return [emPosse, disponiveis];
            },
            seriesTotalPorCategoria() {
                return (this.totaisPorCategoria || []).map(c => c.count || 0);
            }
        }
    }).mount('#app');
</script>
@endsection

<style>
.chart {
    width: 100% !important;
    height: 300px !important; 
}

@media (max-width: 768px) {
    .chart {
        height: 250px;
    }
}
</style>