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
</div>

<script src="https://unpkg.com/vue@3.2.45/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/vue3-apexcharts"></script>

<script>
const { createApp } = Vue;

const totaisEquipamentos = @json($totaisEquipamentos->values() ?? []);
const totaisPorCategoria  = @json($totalPorCategorias->values() ?? []);

createApp({
    components: {
        apexchart: VueApexCharts
    },
    data() {
        return {
            totaisEquipamentos: Array.isArray(totaisEquipamentos) ? totaisEquipamentos : [],
            totaisPorCategoria: Array.isArray(totaisPorCategoria) ? totaisPorCategoria : [],

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
        seriesTotalPorSituacao() {
            const emPosse = this.totaisEquipamentos[0]?.count || 0;
            const disponiveis = this.totaisEquipamentos[1]?.count || 0;
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
