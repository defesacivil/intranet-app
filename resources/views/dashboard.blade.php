@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<section class="container my-5">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Equipamentos</h5>
                    <a href="{{ url('equipamentos') }}" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Categorias</h5>
                    <a href="{{ url('categorias') }}" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Atribuição</h5>
                    <a href="{{ url('equipamentos') }}" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Historico</h5>
                    <a href="{{ url('equipamentos') }}" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
