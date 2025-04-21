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

        @if (!$cartItems->isEmpty())
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
                        Cena
                    </span>
                    <span>
                        Odstrániť z košíka
                    </span>
                </div>
                @foreach ($cartItems as $productSizes)
                    @foreach ($productSizes as $cartItem)
                        <div>
                            <span>
                                <img class="cart-image" src="../images/optimized_products/{{$cartItem['image']}}/1.jpg"
                                    alt="Air Jordan 1">
                            </span>
                            <span>
                                {{$cartItem['name']}}
                            </span>
                            <span>
                                <a
                                    href="{{ route('cart.decrement', ['productId' => $cartItem['product_id'], 'size' => $cartItem['size']]) }}">−</a>
                                <input type="number" value="{{$cartItem['quantity']}}" placeholder="1" required>
                                <a
                                    href="{{ route('cart.increment', ['productId' => $cartItem['product_id'], 'size' => $cartItem['size']]) }}">+</a>
                            </span>
                            <span>
                                <!-- <button onclick="this.nextElementSibling.stepDown()">−</button> -->
                                <input type="number" value="{{$cartItem['size']}}" placeholder="40" required>
                                <!-- <button onclick="this.previousElementSibling.stepUp()">+</button> -->
                            </span>
                            <span>
                                @if ($cartItem['isSale'])
                                    {{ $cartItem['salePrice'] }}
                                @else
                                    {{ $cartItem['price']  }}
                                @endif
                            </span>
                            <span>
                                <a
                                    href="{{ route('cart.remove', ['productId' => $cartItem['product_id'], 'size' => $cartItem['size']]) }}">X</a>
                            </span>
                        </div>
                    @endforeach
                @endforeach

                <button onclick="location.href='order.html';">Prejsť na objednávku</button>
            </section>
        @else
            <h1 class="empty-cart">Nakupný košík je prázdny!</h1>
        @endif



    </main>
@endsection
