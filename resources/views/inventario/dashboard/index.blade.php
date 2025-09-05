@extends('layouts.app')

@section('content')
<div class="container my-4" id="app" v-cloak>
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-bg-primary shadow-sm">
        <div class="card-body">
          <h6>Total de materiais</h6>
          <h3>@{{ totaisEquipamentos[0].count + totaisEquipamentos[1].count }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-bg-success shadow-sm">
        <div class="card-body">
          <h6>Materiais em posse</h6>
          <h3>@{{ totaisEquipamentos[0].count }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-bg-warning shadow-sm">
        <div class="card-body">
          <h6>Materiais disponíveis</h6>
          <h3>@{{ totaisEquipamentos[1].count }}</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6>Disponibilidade/Posse</h6>
          <apexchart class="chart" :options="optionsTotalPorSituacao" :series="seriesTotalPorSituacao" type="donut"></apexchart>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6>Distribuição por Categoria</h6>
          <apexchart class="chart" :options="optionsTotalPorCategoria" :series="seriesTotalPorCategoria" type="donut"></apexchart>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6>📉 Produtos com Estoque Baixo</h6>
          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th>Produto</th>
                <th>Qtd Atual</th>
                <th>Mínimo</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Teclado USB</td>
                <td>2</td>
                <td>10</td>
              </tr>
              <tr>
                <td>Mouse Sem Fio</td>
                <td>5</td>
                <td>15</td>
              </tr>
              <tr>
                <td>Cabo HDMI</td>
                <td>1</td>
                <td>8</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6>📝 Últimas Movimentações</h6>
          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Qtd</th>
                <th>Responsável</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>05/09/2025</td>
                <td>Monitor 24"</td>
                <td><span class="badge bg-success">Entrada</span></td>
                <td>5</td>
                <td>João</td>
              </tr>
              <tr>
                <td>03/09/2025</td>
                <td>Notebook Dell</td>
                <td><span class="badge bg-danger">Saída</span></td>
                <td>2</td>
                <td>Maria</td>
              </tr>
              <tr>
                <td>01/09/2025</td>
                <td>HD Externo</td>
                <td><span class="badge bg-warning text-dark">Ajuste</span></td>
                <td>-1</td>
                <td>Carlos</td>
              </tr>
            </tbody>
          </table>
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
var totaisEquipamentos = @json($totaisEquipamentos->values());
var totaisPorCategoria = @json($totalPorCategorias->values());
 
console.log(totaisPorCategoria);
createApp({
    components: {
        apexchart: VueApexCharts
    },
    data() {
        return {
            optionsTotalPorSituacao: {
                chart: {
                    type: 'donut',
                    toolbar: {
                        show: false
                    }
                },
                labels: ['Disponiveis', 'Em Posse'],
                responsive: [
                    {
                        breakpoint: 1000,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                ]
            },
            optionsTotalPorCategoria: {
                chart: {
                    type: 'donut',
                    toolbar: {
                        show: false
                    }
                },
                labels: totaisPorCategoria.map(totaisPorCategoria => totaisPorCategoria.nome),
                responsive: [
                    {
                        breakpoint: 1000,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                ]
            },
            seriesTotalPorSituacao: [totaisEquipamentos[0].count, totaisEquipamentos[1].count],
            seriesTotalPorCategoria: totaisPorCategoria.map(totaisPorCategoria => totaisPorCategoria.count),
            totaisEquipamentos: @json($totaisEquipamentos->values())
        };
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
[v-cloak] {
    display: none;
}

</style>
