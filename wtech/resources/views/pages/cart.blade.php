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
    </ol>
    </nav>
    @if (count($cartItems))
    <section class="cart">
    <h1>Nákupný košík</h1>
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
      Cena (celkom)
      </span>
      <span>
      Odstrániť z košíka
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
      <a class="qua-button"
      href="{{ route('cart.decrement', ['productId' => $cartItem['product_id'], 'size' => $cartItem['size']]) }}">−</a>
      <input type="number" value="{{$cartItem['quantity']}}" placeholder="1" required>
      <a class="qua-button"
      href="{{ route('cart.increment', ['productId' => $cartItem['product_id'], 'size' => $cartItem['size']]) }}">+</a>
      </span>
      <span>
      <input type="number" value="{{$cartItem['size']}}" disabled required>
      </span>
      <span>
      @if ($cartItem['isSale'])
      {{ $cartItem['salePrice'] * $cartItem['quantity']}}
      @else
      {{ $cartItem['price'] * $cartItem['quantity']  }}
      @endif
      €
      </span>
      <span>
      <a class="qua-button"
      href="{{ route('cart.remove', ['productId' => $cartItem['product_id'], 'size' => $cartItem['size']]) }}">X</a>
      </span>
      </div>
      @endforeach
    @endforeach
    <section class="total">
      <h3>Súčet: <span>{{ $total }}€</span></h3>
    </section>
    <button onclick="location.href='/order';">Prejsť na objednávku </button>
    </section>
    @else
    <h1 class="empty-cart">Nakupný košík je prázdny!</h1>
    @endif


  </main>
@endsection
