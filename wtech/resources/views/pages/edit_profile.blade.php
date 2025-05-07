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
    <form class="login-form" id="edit_profile-form">
      @csrf
      <div>
        <label for="first_name">Krstné meno</label>
        <input type="text" name="first_name" value="{{ $first_name }}" />
      </div>
      <div>
        <label for="last_name">Priezvisko</label>
        <input type="text" name="last_name" value="{{ $last_name }}" />
      </div>
      <div>
        <label for="username">Prezývka</label>
        <input type="text" name="username" value="{{ $username }}" />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="text" name="email" value="{{ $email }}" required/>
      </div>
      <div>
        <label for="phone">Telefónne číslo</label>
        <input type="tel" name="phone" placeholder="v tvare +421xxxxxxxxx" value="{{ $phone }}" />
      </div>
      <div>
        <label for="city">Mesto</label>
        <input type="text" name="city" value="{{ $city }}" />
      </div>
      <div>
        <label for="postal_code">PSČ</label>
        <input type="text" name="postal_code" value="{{ $postal_code }}" />
      </div>
      <div>
        <label for="street">Ulica a číslo domu</label>
        <input type="text" name="street" value="{{ $street }}" />
      </div>
      <button type="submit">Uložiť zmeny</button>
    </form>
    </section>
  </main>

@endsection
