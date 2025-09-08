@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<style>
  body {
      min-height: 100vh;
      background-image:
          radial-gradient(circle at 22% 18%, rgba(255, 255, 255, 0.07) 0%, rgba(255, 255, 255, 0) 28%),
          linear-gradient(135deg, var(--dc-navy) 0%, var(--dc-blue) 45%, #FF7A1A 100%);
      background-attachment: fixed;
      background-repeat: no-repeat;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
  }
</style>
<div class="container py-5">
  <div class="row justify-content-center vh-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-5">
      <div class="card login-card">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <img src="https://www.mg.gov.br/sites/default/files/styles/large/public/media/image/2025/02/logo-defesa-civil-2.png?itok=NhfQmxcj"
                 alt="Logo Defesa Civil" class="img-fluid login-logo">
          </div>
          <form method="POST" action="/logar" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold text-secondary">E-mail</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold text-secondary">Senha</label>
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" minlength="6" required>
              </div>
            </div>

            <button class="btn btn-dc w-100 text-white" type="submit">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
