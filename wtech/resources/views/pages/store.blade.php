@extends('master')

@section('content')
    <main>
        <ol class="breadcrumb">
            <li><a href="./mainpage.html">Domov</a></li>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
            </svg>
            <li><a href="./store.html">Produkty</a></li>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
            </svg>
            <li><a href="./store.html">Muži</a></li>
        </ol>

        <section id="mobile-filter">
            <div class="mobile-filter-header">
                <h1>Filter</h1>
                <button onclick="toggleMobileFilter()">
                    <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="38" height="38">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <hr class="darker-hr">
            <h4>Cena</h4>
            <div class="filter-section">
                <div class="flex">
                    <div class="price-box">
                        <input class="price-input" name="price-from" type="number" value="0" min="0" max="9999">
                        <label for="price-from">od</label>
                    </div>
                    <span>-</span>
                    <div class="price-box">
                        <input class="price-input" name="price-to" type="number" value="1400" min="0" max="9999">
                        <label for="price-to">do</label>
                    </div>
                </div>
            </div>
            <h4>Farba</h4>
            <div class="filter-section" id="color-selection">
                <button class="color-select" style="background-color: red;"></button>
                <button class="color-select" style="background-color: blue;"></button>
                <button class="color-select" style="background-color: yellow;"></button>
                <button class="color-select" style="background-color: magenta;"></button>
            </div>
            <h4>Veľkosť</h4>
            <div class="filter-section" id="size-selection">
                <button class="size-select">36</button>
                <button class="size-select">37</button>
                <button class="size-select">38</button>
                <button class="size-select">39</button>
                <button class="size-select">40</button>
                <button class="size-select">41</button>
                <button class="size-select">42</button>
                <button class="size-select">43</button>
            </div>
            <h4>Značka</h4>
            <div class="filter-section">
                <div>
                    <input type="checkbox" class="brand-nike" name="brand-nike" />
                    <label for="brand-nike">Nike</label>
                </div>
                <div>
                    <input type="checkbox" class="brand-Reebok" name="brand-Reebok" />
                    <label for="brand-Reebok">Reebok</label>
                </div>
                <div>
                    <input type="checkbox" class="brand-Adidas" name="brand-Adidas" />
                    <label for="brand-Adidas">Adidas</label>
                </div>
            </div>
            <button id="filter-button">Filtrovať</button>
        </section>

        <div class="flex" id="store-container">
            <section id="filter">
                <h1>Filter</h1>
                <hr class="darker-hr">


                <h4>Cena</h4>
                <div class="filter-section">
                    <div class="flex">
                        <div class="price-box">
                            <input class="price-input" name="price-from" type="number" value="0" min="0" max="9999">
                            <label for="price-from">od</label>
                        </div>
                        <span>-</span>
                        <div class="price-box">
                            <input class="price-input" name="price-to" type="number" value="1400" min="0" max="9999">
                            <label for="price-to">do</label>
                        </div>
                    </div>
                </div>



                <h4>Farba</h4>
                <div class="filter-section padding-filter" id="color-selection">
                    <button class="color-select" style="background-color: red;"></button>
                    <button class="color-select" style="background-color: blue;"></button>
                    <button class="color-select" style="background-color: yellow;"></button>
                    <button class="color-select" style="background-color: magenta;"></button>
                </div>



                <h4>Veľkosť</h4>
                <div class="filter-section padding-filter" id="size-selection">
                    <button class="size-select">36</button>
                    <button class="size-select">37</button>
                    <button class="size-select">38</button>
                    <button class="size-select">39</button>
                    <button class="size-select">40</button>
                    <button class="size-select">41</button>
                    <button class="size-select">42</button>
                    <button class="size-select">43</button>
                </div>


                <h4>Značka</h4>
                <div class="filter-section">
                    <div>
                        <input type="checkbox" class="brand-nike" name="brand-nike" />
                        <label for="brand-nike">Nike</label>
                    </div>
                    <div>
                        <input type="checkbox" class="brand-Reebok" name="brand-Reebok" />
                        <label for="brand-Reebok">Reebok</label>
                    </div>
                    <div>
                        <input type="checkbox" class="brand-Adidas" name="brand-Adidas" />
                        <label for="brand-Adidas">Adidas</label>
                    </div>
                </div>

                <button id="filter-button">Filtrovať</button>
            </section>


            <section id="products">
                <div class="store-top">
                    <h1>Muži</h1>
                    <div>
                        <label for="sort" id="sort-label">Zoradiť podľa:</label>
                        <select id="sort" name="sort">
                            <option value="price-asc">Cena: od najnižšej</option>
                            <option value="price-desc">Cena: od najvyššej</option>
                            <option value="alphabetical">Abecedne</option>
                            <option value="newest">Najnovšie</option>
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

                        @forelse($products as $product)
                            @include('components.product', ['product' => $product])
                        @empty
                            <p>Neboli nájdene žiadné nové produkty!</p>
                        @endforelse

                    </div>

                    @if ($products->lastPage() > 1)
                        <section class="pagination">
                            @if ($products->onFirstPage())
                                <button class="pagination-button" disabled>‹</button>
                            @else
                                <a href="{{ $products->previousPageUrl() }}">
                                    <button class="pagination-button">‹</button>
                                </a>
                            @endif

                            @for ($i = 1; $i <= $products->lastPage(); $i++)
                                @if ($i == $products->currentPage())
                                    <button class="pagination-button active">{{ $i }}</button>
                                @else
                                    <a href="{{ $products->url($i) }}">
                                        <button class="pagination-button">{{ $i }}</button>
                                    </a>
                                @endif
                            @endfor

                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}">
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
