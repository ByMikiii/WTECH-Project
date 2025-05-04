@extends('master')

@section('content')
<main>
  <ol class="breadcrumb">
    <li><a href="/">Domov</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="/new">{{ $product->gender }}</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="/{{ $product->slug }}">{{ $product->name }}</a></li>
  </ol>

  <section class="product-main">
    <div id="carouselExampleIndicators" class="carousel slide product-carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        @for ($i = 1; $i < $imagesCount; $i++)
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}"
        aria-label="Slide " . {{ $i + 1 }}></button>
    @endfor
      </div>
      <div class="carousel-inner">
        @for ($i = 1; $i <= $imagesCount; $i++)
      <div
        class="carousel-item
        @if ($i == 1)
          active
        @endif
        ">
        <img src="../images/optimized_products/{{ $product->slug }}/{{ $i }}.jpg" class="d-block product-photo"
        alt="Obrázok produktu {{ $i }}">
      </div>
    @endfor
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Predošlý</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Ďaľší</span>
      </button>
    </div>
    <div class="product-details">
      <div>
        <h1>{{ $product->name }}</h1>
        <div class="product-rating">
          @for ($i = 1; $i <= 5; $i++)
        <svg data-slot="icon" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
        fill="{{ $averageRating >= $i ? "gold" : "none" }}" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
        width="24px" height="24px">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z">
        </path>
        </svg>
      @endfor
          <span>{{ $averageRating }} / 5 ({{ count($otherReviews) + (empty($ownReview) ? 0 : 1) }})</span>
        </div>
      </div>
      <form class="details-bottom" method="POST" action="{{ route('cart.add', ['productId' => $product->id]) }}">
        @csrf
        <div class="product-stats">
        @if(isset($sizes[0]->size))
          <div class="product-size-selection">
            <h4>Veľkosť: </h4>
            <div class="filter-section" id="size-selection">
              <input type="hidden" name="size" id="selected-size" value="{{ $sizes[0]->size ?? 0 }}">
            @foreach ($sizes as $size)
              @if ($size->stock > 0)
                <button type="button"
                class="product-size-select {{ $loop->first ? 'selected' : '' }}">{{ $size->size }}</button>
              @endif
            @endforeach
            </div>
          </div>
          <div class="product-counter">
            <h4>Počet kusov: </h4>
            <div class="quantity-container">
              <button type="button" class="quantity-button" id="decrease"
                onclick="this.nextElementSibling.stepDown()">-</button>
              <input type="number" id="product-quantity" name="quantity" min="1" max="5" value="1" />
              <button type="button" class="quantity-button" id="increase"
                onclick="this.previousElementSibling.stepUp()">+</button>
            </div>
          </div>
        </div>
        @endif
        <div class="product-prices page-prices">
          @if ($product->isSale)
        <h1 class="old-price">{{ $product->price }}€</h1>
      @endif
          <h1>
            @if ($product->isSale)
        {{ $product->salePrice }}
      @else
    {{ $product->price }}
  @endif
            €
          </h1>
        </div>


        @if(isset($sizes[0]->size))
        <div class="product-buttons">
          <button type="submit" class="button-cart" id="product-button">
            <svg class="button-cart-icon" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z">
              </path>
            </svg>
            <span>
              Vložiť do košíka
            </span>
          </button>
          @if (Auth::check() && Auth::user()->role == 'admin')
        <button class="button-edit">
        <a href="/{{$product->slug}}/edit">
          <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="28" height="28">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125">
          </path>
          </svg>
          <span>
          Upraviť produkt
          </span>
        </a>
        </button>
      @endif
        </div>

        @endif
      </form>
    </div>
    @if(!isset($sizes[0]))
      <h3>Produkt momentálne nie je dostupný.</h3>
    @endif
  </section>


  <section class="product-description">

    <div class="description-param">
      <div class="description-item">
        <h2>Popis</h2>
        <hr>
        <p class="under-desc">
          {{ $product->description }}
        </p>
      </div>

      <div class="description-item">
        <h2>Špecifikácia</h2>
        <hr>
        <ul class="under-desc">
          <li class="spec-item"><strong>Výrobca: </strong>{{ $product->manufacturer }}</li>
          <li class="spec-item"><strong>Typ: </strong>{{ $product->type }}</li>
          <li class="spec-item"><strong>Farba: </strong>{{ $product->color }}</li>
          <li class="spec-item"><strong>Pohlavie: </strong> {{ $product->gender }} </li>
          <li class="spec-item"><strong>Dátum vydania: </strong>
            {{ \Carbon\Carbon::parse($product->release_date)->format('d. m. Y') }} </li>
        </ul>
      </div>
    </div>


    <div class="description-item">
      <h2>Recenzie - {{ $averageRating }}/5 ({{ count($otherReviews) + (empty($ownReview) ? 0 : 1) }})</h2>
      <hr>
      @if (Auth::check())
      <div class="review-box" id="create-review">
      <div class="review-header">
        <div>
        @for ($i = 1; $i <= 5; $i++)
      <svg data-slot="icon" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24px" height="24px" @if (empty($ownReview))
    class="star" data-value="{{$i}}" @elseif($ownReview->rating >= $i) fill="gold" @else fill="none" @endif>
        <path stroke-linecap="round" stroke-linejoin="round"
        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z">
        </path>
      </svg>
    @endfor
        </div>
        {{ isset($ownReview) ? \Carbon\Carbon::parse($ownReview->created_at)->format('d. m. Y') : "" }}
      </div>

      <form method="POST"
        action="{{ empty($ownReview) ? '/review/create/' . $product->id : '/review/delete/' . $product->id }}"
        class="review-form">
        @csrf
        <input type="hidden" name="rating" value="{{ isset($ownReview) ? $ownReview->rating : "1"}}">
        <textarea name="text" class="review-input" {{ isset($ownReview) ? "disabled " : ""}}
        placeholder="Sem môžete napísať svoju recenziu..."
        maxlength="364">{{ isset($ownReview) ? $ownReview->text : ""}}</textarea>
        <span class="review-author" id="review-submit">
        <button type="submit">{{ isset($ownReview) ? "Odstrániť " : "Odoslať"}}</button>
        </span>
      </form>
      </div>
    @endif
      <div class="reviews">
        @foreach ($otherReviews as $review)
        <div class="review-box">
          <div class="review-header">
            <div>
              @for ($i = 1; $i <= 5; $i++)
              <svg data-slot="icon" @if($review->rating >= $i) fill="gold" @else fill="none" @endif stroke-width="1.5"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                width="24px" height="24px">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z">
                </path>
              </svg>
              @endfor
            </div>
            <small>{{\Carbon\Carbon::parse($review->created_at)->format('d. m. Y')}}</small>
          </div>
          <span class="review-text">
            {{$review->text}}
          </span>
          <span class="review-author">{{$review->user->username ? $review->user->username : "Zakazník"}}</span>
        </div>
        @endforeach
      </div>
    </div>
  </section>

</main>
@endsection
