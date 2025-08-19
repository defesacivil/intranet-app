<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Inventário</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/equipamentos') }}">Equipamentos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/categorias') }}">Categorias</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/usuarios') }}">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Relatórios</a></li>
            </ul>
        </div>
    </div>
</nav>
