@extends('master')

@section('content')
  <main>
    <nav aria-label="Breadcrumb">
    <ol class="breadcrumb">
      <li><a href="/">Domov</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/register">Registrácia</a></li>
    </ol>
    </nav>

    <section class="container">
    <h1>Registrácia</h1>
    <form id="registration-form" class="login-form">
      <div>
      <label for="email">E-mail:</label>
      <input type="email" name="email" required>
      </div>
      <div>
      <label for="password">Heslo:</label>
      <input type="password" name="password" required>
      </div>
      <div>
      <label for="password">Potvrdiť heslo:</label>
      <input type="password" name="password_confirmation" required>
      </div>
      <button type="submit">Registrovať</button>
    </form>
    <p>Máte už účet? <a href="/login">Prihlásiť sa</a></p>

    </section>
  </main>
@endsection
