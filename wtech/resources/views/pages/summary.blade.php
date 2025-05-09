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
    </ol>
    </nav>

    @if (!$cartItems->isEmpty())
    <section class="cart">
    <h1>Zhrnutie objednávky</h1>
    <div id="first_div">
      <span>
      Obrázok
      </span>
      <span>
      Názov produktu
      </span>
      <span>
      Počet kusov
      </span>
      <span>
      Veľkosť
      </span>
      <span>
      Cena
      </span>
    </div>
    @foreach ($cartItems as $productSizes)
    @foreach ($productSizes as $cartItem)
    <div>
      <a href="{{$cartItem['image']}}">
      <img class="cart-image" src="../images/optimized_products/{{$cartItem['image']}}/1.jpg" alt="Air Jordan 1">
      </a>
      <a href="{{$cartItem['image']}}">
      {{$cartItem['name']}}
      </a>
      <span>

      <input type="number" value="{{$cartItem['quantity']}}" placeholder="1" required>

      </span>
      <span>
      <!-- <button onclick="this.nextElementSibling.stepDown()">−</button> -->
      <input type="number" value="{{$cartItem['size']}}" disabled required>
      <!-- <button onclick="this.previousElementSibling.stepUp()">+</button> -->
      </span>

      <span>
      @if ($cartItem['isSale'])
      {{ $cartItem['salePrice'] * $cartItem['quantity']}}€
    @else
      {{ $cartItem['price'] * $cartItem['quantity']}}€
    @endif
      </span>
    </div>
  @endforeach
  @endforeach
  </section>
  <!-- nedoriesene -->
  <section class="profile">
  <h1>Dodacie údaje</h1>
  <div>
    <label for="name">Meno</label>
    <span name="name">{{ $order_data['first_name'] }} {{ $order_data['last_name'] }}</span>
  </div>
  <div>
    <label for="e-mail">E-mail</label>
    <span name="e-mail">{{ $order_data['email'] }}</span>
  </div>
  <div>
    <label for="phone">Telefónne číslo</label>
    <span name="phone">{{ $order_data['phone'] }}</span>
  </div>
  <div>
    <label for="address">Adresa</label>
    <span name="address">{{ $order_data['street'] }}, {{ $order_data['city'] }}, {{ $order_data['postal_code'] }}</span>
  </div>
  <div>
    <label for="delivery">Spôsob prepravy</label>
    <span name="delivery">{{ $order_data['delivery'] }}</span>
  </div>
  <div>
    <label for="pay">Spôsob platby</label>
    <span name="pay">{{ $order_data['pay'] }}</span>
  </div>
    <!--<button onclick="location.href='/';">Dokončiť objednávku | {{ $total }}€</button>-->
    <button onclick="location.href='{{ $order_data['pay'] == 'Platba kartou' ? '/card_pay' : '/bank_pay' }}';"
      id="price_button">Prejsť k platbe | <span id="price">{{ $total }}€</span></button>
    <!--<h2>{{ $total }}€</h2>-->
    </section>
  @else
  <h1 class="empty-cart">Nakupný košík je prázdny!</h1>
@endif



  </main>
@endsection
