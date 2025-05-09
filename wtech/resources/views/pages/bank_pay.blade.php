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
      <li><a href="/bank_pay">Platba bankovým prevodom</a></li>
    </ol>
    </nav>

    <section class="profile">
    <h1>Údaje k platbe bankovým prevodom</h1>
    <div>
      <label for="number">Číslo účtu</label>
      <span name="number">SK54 7500 0000 0012 3456 7890</span>
    </div>
    <div>
      <label for="name">Meno príjemcu</label>
      <span name="name">NaNohu</span>
    </div>
    <div>
      <label for="price">Cena</label>
      <span name="price">{{ $total }}€</span>
    </div>
    <div>
      <label for="price">Poznámka pre príjemcu</label>
      <span name="price">{{ $order_data['first_name'] }} {{ $order_data['last_name'] }}</span>
    </div>
    <button type="submit">Potvrdiť objednávku s povinnosťou platby</button>
    </section>
  </main>
@endsection
