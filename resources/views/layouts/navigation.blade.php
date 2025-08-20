<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="fas fa-boxes me-2"></i>Inventário
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <!-- Equipamentos -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/equipamentos') }}">
                        <i class="fas fa-tools me-1 text-primary"></i>Equipamentos
                    </a>
                </li>

                <!-- Categorias -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/categorias') }}">
                        <i class="fas fa-tags me-1 text-success"></i>Categorias
                    </a>
                </li>

                <!-- Atribuição -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/usuarios') }}">
                        <i class="fas fa-user-check me-1 text-warning"></i>Usuarios
                    </a>
                </li>

                <!-- Histórico -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/historico') }}">
                        <i class="fas fa-history me-1 text-danger"></i>Histórico
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
