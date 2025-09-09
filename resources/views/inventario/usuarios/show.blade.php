@extends('layouts.app')

@section('title', 'Editar Equipamentos do Usuário')

@section('content')
<div id="app" class="container my-4" v-cloak>

  <h1 class="mb-4">Equipamentos do Usuário: {{ $usuario['nome'] }}</h1>

  <div class="row">
    <section class="col-md-12 mb-4">
      <h4>Equipamentos Atuais <span class="badge bg-primary">@{{ equipamentosAtivos.length }}</span></h4>
      
      <input type="text" v-model="searchAtivos" class="form-control mb-3" placeholder="Buscar equipamentos ativos...">

      <ul class="list-group overflow-auto" style="max-height: 400px;">
        <li v-for="(rel, index) in filteredAtivos" :key="rel.id" class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>@{{ rel.equipamento.nome }}</strong><br>
            <small class="text-muted">Número de Patrimônio: @{{ rel.equipamento.patrimonio }} | Adicionado em: @{{ formatDate(rel.created_at) }}</small>
          </div>
        </li>
        <li v-if="filteredAtivos.length === 0" class="list-group-item text-center text-muted">Nenhum equipamento encontrado.</li>
      </ul>
    </section>
  </div>

  <div v-if="mensagem" class="alert mt-3" :class="{'alert-success': sucesso, 'alert-danger': !sucesso}" role="alert">
    @{{ mensagem }}
  </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      usuario: @json($usuario),
      equipamentosAtivos: @json($usuarioEquipamentos),
      equipamentosDisponiveis: @json($equipamentosDisponiveis),
      searchAtivos: '',
      searchDisponiveis: '',
      loading: false,
      selecionadosParaAdicionar: [],
      selecionadosParaRemover: [],
      mensagem: '',
      sucesso: true,
    };
  },
  computed: {
    filteredAtivos() {
      if (!this.searchAtivos) return this.equipamentosAtivos;
      return this.equipamentosAtivos.filter(rel =>
        rel.equipamento.nome.toLowerCase().includes(this.searchAtivos.toLowerCase())
      );
    },
    filteredDisponiveis() {
      if (!this.searchDisponiveis) return this.equipamentosDisponiveis.data;
      return this.equipamentosDisponiveis.data.filter(equip =>
        equip.nome.toLowerCase().includes(this.searchDisponiveis.toLowerCase())
      );
    }
  },
  methods: {
    formatDate(dateStr) {
      const d = new Date(dateStr);
      return d.toLocaleDateString() + ' ' + d.toLocaleTimeString();
    },
    removerEquipamento(index) {
      const eq = this.equipamentosAtivos[index];
      this.selecionadosParaRemover.push(eq.equipamento.id);
      this.equipamentosDisponiveis.data.push(eq.equipamento);
      this.equipamentosAtivos.splice(index, 1);
    },
    adicionarEquipamento(equip) {
      this.selecionadosParaAdicionar.push(equip.id);
      this.equipamentosDisponiveis.data = this.equipamentosDisponiveis.data.filter(e => e.id !== equip.id);
      this.equipamentosAtivos.push({
        id: `novo-${equip.id}`,
        equipamento: equip,
        created_at: new Date().toISOString(),
      });
    },
    async fetchEquipamentos(page) {
      if (page < 1 || page > this.equipamentosDisponiveis.last_page) return;
      this.loading = true;
      try {
        const res = await axios.get(`/api/equipamentos?page=${page}&excludeUserId=${this.usuario.id_usuario}`);
        this.equipamentosDisponiveis = res.data;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    async salvar() {
      if (this.loading) return;
      this.loading = true;
      this.mensagem = '';
      try {
        await axios.post(`/usuarios/store/`, {
          equipamentos: {
            user: this.usuario.id_usuario,
            nomeUser: this.usuario['nome'],
            add: this.selecionadosParaAdicionar,
            remove: this.selecionadosParaRemover,
          }
        });
        this.sucesso = true;
        this.mensagem = 'Alterações salvas com sucesso!';
        await this.fetchEquipamentos(1);
        this.selecionadosParaAdicionar = [];
        this.selecionadosParaRemover = [];
      } catch (error) {
        this.sucesso = false;
        this.mensagem = 'Erro ao salvar alterações.';
        console.error(error);
      } finally {
        this.loading = false;
      }
    }
  }
}).mount('#app');
</script>
@endsection
