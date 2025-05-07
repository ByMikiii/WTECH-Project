@extends('master')

@section('content')
  <main>
    <nav aria-label="Breadcrumb">
    <ol class="breadcrumb">
      <li><a href="/">Domov</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/cart">Košík</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/order">Objednávka</a></li>
    </ol>
    </nav>

    <section class="container">
    <h1>Dodacie údaje</h1>
    <form class="login-form" method="POST" action="/order">
    @csrf
      <div>
        <label for="first_name">Krstné meno</label>
        <input type="text" name="first_name" value="{{ $first_name }}" required />
      </div>
      <div>
        <label for="last_name">Priezvisko</label>
        <input type="text" name="last_name" value="{{ $last_name }}" required />
      </div>
      <div>
        <label for="email">E-mail</label>
        <input type="text" name="email" value="{{ $email }}" required />
      </div>
      <div>
        <label for="phone">Telefónne číslo</label>
        <input type="tel" name="phone" placeholder="v tvare +421xxxxxxxxx" value="{{ $phone }}" required />
      </div>
      <div>
        <label>Spôsob prepravy</label>
        <select>
          <option value="1">Kuriér</option>
          <option value="2">Osobné prevzatie</option>
          <option value="3">Poštovou službou</option>
        </select>
      </div>
      <div>
        <label>Spôsob platby</label>
        <select>
          <option value="1">Bankovým prevodom</option>
          <option value="2">Platba kartou</option>
        </select>
        </div>
      <div>
        <label for="city">Mesto</label>
        <input type="text" name="city" value="{{ $city }}" required />
      </div>
      <div>
        <label for="postal_code">PSČ</label>
        <input type="text" name="postal_code" value="{{ $postal_code }}" required />
      </div>
      <div>
        <label for="street">Ulica a číslo domu</label>
        <input type="text" name="street" value="{{ $street }}" required />
      </div>

      <button type="submit">Dokončiť objednávku</a></button>
    </form>
    </section>
  </main>

@endsection
