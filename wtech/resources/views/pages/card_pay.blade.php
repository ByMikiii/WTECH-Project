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
      <li><a href="/order">Dodacie údaje</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/summary">Zhrnutie</a></li>
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
      </svg>
      <li><a href="/card_pay">Platba kartou</a></li>
    </ol>
    </nav>

    <section class="container">
    <h1>Platba kartou</h1>
    <form id="pay-form" class="login-form">
      @csrf
      <div>
      <label for="card_number">Číslo karty</label>
      <input type="text" name="card_number" required />
      </div>
      <div>
      <label for="duration">Platnosť karty</label>
      <input type="text" name="duration" required />
      </div>
      <div>
      <label for="cvv">CVV</label>
      <input type="text" name="cvv" required />
      </div>
      <button onclick="location.href='/create_order';">Potvrdiť objednávku a platbu</button>
    </form>
    </section>
  </main>
@endsection
