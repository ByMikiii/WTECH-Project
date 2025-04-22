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
        <li><a href="/edit_profile">Upraviť profil</a></li>
      </ol>
    </nav>

    <section class="container">
      <h1>Upraviť profil</h1>
      <form class="login-form">
        <div>
          <label for="name">Meno a priezvisko</label>
          <input type="text" name="name" />
        </div>
        <div>
          <label for="email">Email</label>
          <input type="text" name="email" value="example@example.com" />
        </div>
        <div>
          <label for="number">Telefónne číslo</label>
          <input type="tel" name="number" placeholder="v tvare +421xxxxxxxxx" />
        </div>
        <div>
          <label for="address">Adresa</label>
          <input type="text" name="address" placeholder="Ulica číslo, Mesto, PSČ" />
        </div>
        <button type="submit">Uložiť zmeny</button>
      </form>
    </section>
  </main>

@endsection