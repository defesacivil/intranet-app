@ -1,54 +1,17 @@
@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<section class="container my-5">
    <div class="row g-4 justify-content-center">
        <!-- Equipamentos -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-tools fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title">Equipamentos</h5>
                    <a href="{{ url('equipamentos') }}" class="btn btn-outline-primary mt-2">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Categorias -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-tags fa-3x mb-3 text-success"></i>
                    <h5 class="card-title">Categorias</h5>
                    <a href="{{ url('categorias') }}" class="btn btn-outline-success mt-2">Acessar</a>
                </div>
            </div>
        </div>

        <!-- Atribuição -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-user-check fa-3x mb-3 text-warning"></i>
                    <h5 class="card-title">Usuarios</h5>
                    <a href="{{ url('usuarios') }}" class="btn btn-outline-warning mt-2">Usuarios</a>
                </div>
            </div>
        </div>

        <!-- Histórico -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-history fa-3x mb-3 text-danger"></i>
                    <h5 class="card-title">Histórico</h5>
                    <a href="{{ url('historico') }}" class="btn btn-outline-danger mt-2">Acessar</a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
