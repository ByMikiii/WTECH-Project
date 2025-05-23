@extends('master')

@section('content')
  <section href="" id="hot-product">
    <div>
    <a href="/{{ $hotProduct->slug }}" class="hot-name">{{$hotProduct->name}}</a>
    <div id="hot-sale">
      <div class="prices">
      <h1 class="old-price">{{$hotProduct->price}}€</h1>
      <h1>{{$hotProduct->salePrice}}€</h1>
      </div>
      <form method="POST" action="{{ route('cart.add', ['productId' => $hotProduct->id]) }}">
      @csrf
      <input type="hidden" name="size" value="36">
      <input type="hidden" name="quantity" value="1">
      <button type="submit" id="hot-button">
        Vložiť do košíka
      </button>
      </form>
    </div>
    </div>
  </section>

  <main>
    <section class="product-section">
    <h2 class="product-section-header">Novinky</h2>
    <div class="product-list">
      @forelse($newProducts as $product)
      @include('components.product', ['product' => $product])
    @empty
      <p>Neboli nájdene žiadné nové produkty!</p>
    @endforelse
    </div>
    <a href="/new"><button class="view-more">Zobraziť viac</button></a>
    </section>

    <hr class="section-break">

    <section class="product-section">
    <h2 class="product-section-header">Výpredaj</h2>
    <div class="product-list">
      @forelse($saleProducts as $product)
      @include('components.product', ['product' => $product])
    @empty
      <p>Žiadné produkty nie sú v zľave!</p>
    @endforelse
    </div>
    <a href="/sale"><button class="view-more">Zobraziť viac</button></a>
    </section>
  </main>

@endsection
