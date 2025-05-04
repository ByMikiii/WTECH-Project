@extends('master')

@section('content')
  <main>
    <nav aria-label="Breadcrumb">
    <ol class="breadcrumb">
      <li><a href="/">Domov</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/profile">Profil</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/change_password">Zmena hesla</a></li>
    </ol>
    </nav>

    <section class="container">
    <h1>Zmena hesla</h1>
    <form class="login-form">
      <div>
      <label for="current_password">Aktuálne heslo</label>
      <input type="password" name="current_password" required />
      </div>
      <div>
      <label for="new_password">Nové heslo</label>
      <input type="password" name="new_password" required />
      </div>
      <div>
      <label for="retype_password">Potvrdiť heslo</label>
      <input type="password" name="retype_password" required />
      </div>
      <button type="submit">Uložiť zmenu</button>
    </form>
    </section>
  </main>
@endsection
