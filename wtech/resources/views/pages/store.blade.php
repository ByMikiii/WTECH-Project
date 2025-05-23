@extends('master')

@section('content')
  <main>
    <ol class="breadcrumb">
    <li><a href="/">Domov</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="/">Produkty</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="{{ url()->current() }}">{{ $category }}</a></li>
    </ol>

    <div class="flex" id="store-container">
    <form id="filter" method="GET" action="/filter">
      <div class=" mobile-filter-header">
      <h1>Filter</h1>
      <button id="filter-close" type="button" onclick="toggleMobileFilter()">
        <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="38" height="38">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
        </svg>
      </button>
      </div>
      <hr class=" darker-hr">

      <input type="hidden" name="sort" id="sort-input" value="newest">

      <h4>Cena</h4>
      <div class="filter-section">
      <div class="flex">
        <div class="price-box">
        <input class="price-input" name="price-from" type="number" value="{{isset($priceFrom) ? $priceFrom : 0}}"
          min="0" max="9999">
        <label for="price-from">od</label>
        </div>
        <span>-</span>
        <div class="price-box">
        <input class="price-input" name="price-to" type="number" value="{{isset($priceTo) ? $priceTo : 1999}}"
          min="0" max="9999">
        <label for="price-to">do</label>
        </div>
      </div>
      </div>
      <h4>Farba</h4>
      <div id="selected-colors-container">
      @if(isset($colors))
      @foreach ($colors as $clr)
      <input type="hidden" name="color[]" value="{{$clr}}">
      @endforeach
    @endif
      </div>
      <div class="filter-section padding-filter" id="color-selection">
      <button type="button" class="color-select {{ in_array('red', $colors ?? []) ? 'selected' : '' }}"
        style="background-color: red;"></button>
      <button type="button" class="color-select {{ in_array('blue', $colors ?? []) ? 'selected' : '' }}"
        style="background-color: blue;"></button>
      <button type="button" class="color-select {{ in_array('yellow', $colors ?? []) ? 'selected' : '' }}"
        style="background-color: yellow;"></button>
      <button type="button" class="color-select {{ in_array('magenta', $colors ?? []) ? 'selected' : '' }}"
        style="background-color: magenta;"></button>
      </div>

      <h4>Veľkosť</h4>
      <div class="filter-section padding-filter" id="size-selection">
      @foreach(range(36, 43) as $size)
      <label>
      <input type="checkbox" name="size[]" value="{{ $size }}" {{ in_array($size, $sizes ?? []) ? 'checked' : '' }}>
      {{ $size }}
      </label>
    @endforeach
      </div>


      <h4>Značka</h4>
      <div class="filter-section">
      <div>
        <input type="checkbox" class="brand-nike" name="brand[]" value="Nike" {{ in_array('Nike', $brands ?? []) ? 'checked' : '' }} />
        <label for="brand-nike">Nike</label>
      </div>
      <div>
        <input type="checkbox" class="brand-Reebok" name="brand[]" value="Reebok" {{ in_array('Reebok', $brands ?? []) ? 'checked' : '' }} />
        <label for="brand-Reebok">Reebok</label>
      </div>
      <div>
        <input type="checkbox" class="brand-Adidas" name="brand[]" value="Adidas" {{ in_array('Adidas', $brands ?? []) ? 'checked' : '' }} />
        <label for="brand-Adidas">Adidas</label>
      </div>
      </div>

      <button id="filter-button">Filtrovať</button>
    </form>


    <section id="products">
      <div class="store-top">
      <h1>{{ $category }}</h1>
      <div id="sortBy">
        <label for="sort" id="sort-label">Zoradiť podľa:</label>
        <select id="sort" name="sort" onchange="sortSubmit()">
        <option value="newest" {{ isset($sort) && $sort == 'newest' ? 'selected' : '' }}>Najnovšie
        <option value="price-asc" {{ isset($sort) && $sort == 'price-asc' ? 'selected' : '' }}>Cena: od
          najnižšej</option>
        <option value="price-desc" {{ isset($sort) && $sort == 'price-desc' ? 'selected' : '' }}>Cena: od
          najvyššej
        </option>
        <option value="alphabetical" {{ isset($sort) && $sort == 'alphabetical' ? 'selected' : '' }}>
          Abecedne</option>
        </option>
        </select>
      </div>
      <button onclick="toggleMobileFilter()">
        <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="34" height="34">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z">
        </path>
        </svg>
      </button>
      </div>
      <hr>
      <section class="product-section">
      <div class="product-list">

        @if(Auth::check() && Auth::user()->role == 'admin')
      <div class="product-box" id="add-product">
      <a href="/add_product">
        <div class="product-image" id="add-product-image">
        <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="gray" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="72" height="72" class="add-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
        </svg>
        </div>
      </a>
      </div>
      @endif

        @forelse($products as $product)
      @include('components.product', ['product' => $product])
      @empty
      <h2 class="no-products">Neboli nájdene žiadné produkty!</h2>
      @endforelse

      </div>


      @php
      #without this the other params would disappear
      $queryParams = request()->except('page');
    @endphp

      @if ($products->lastPage() > 1)
      <section class="pagination">
        @if ($products->onFirstPage())
      <button class="pagination-button" disabled>‹</button>
      @else
      <a href="{{ $products->previousPageUrl() . '&' . http_build_query($queryParams) }}">
      <button class="pagination-button">‹</button>
      </a>
      @endif

        @for ($i = 1; $i <= $products->lastPage(); $i++)
        @if ($i == $products->currentPage())
      <button class="pagination-button active">{{ $i }}</button>
      @else
      <a href="{{ $products->url($i) . '&' . http_build_query($queryParams) }}">
      <button class="pagination-button">{{ $i }}</button>
      </a>
      @endif
      @endfor

        @if ($products->hasMorePages())
      <a href="{{ $products->nextPageUrl() . '&' . http_build_query($queryParams) }}">
      <button class="pagination-button">›</button>
      </a>
      @else
      <button class="pagination-button" disabled>›</button>
      @endif
      </section>
    @endif

      </section>
    </section>
    </div>
    </nav>


  </main>
@endsection
