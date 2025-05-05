@extends('master')

@section('content')
  <main>
    <ol class="breadcrumb">
    <li><a href="/">Domov</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="/men">Muži</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="/{{ $product->slug }}">Air Jordan 1 Retro High OG 'Travis Scott'</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="">Upraviť produkt</a></li>
    </ol>


    <form method="POST" action="/products/{{ $product->id }}/edit" enctype="multipart/form-data" class="add-product-form">
    @csrf
    <h1>Upraviť produkt</h1>

    <div class="add-form-input">
      <label>Obrázky produktu</label>
      @for ($i = 1; $i <= $imagesCount; $i++)
      <div class="existing-image" id="product-image-{{ $i }}">
      <img class="edit-product-image" src="../images/optimized_products/{{ $product->slug }}/{{ $i }}.jpg"
      alt="Obrázok produktu {{ $i }}">
      <button type="button" class="edit-remove-button" onclick="removeImage('{{ $i }}')">
      <svg width="40" height="40" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
      viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
      </svg>
      </button>
      </div>
    @endfor
    </div>

    <div class="add-form-input">
      <label for="product-images">Pridať obrázky</label>
      <input name="product-images[]" type="file" name="product-image" accept="image/png, image/jpeg, image/jpg"
      multiple />
    </div>

    <div class="add-form-input">
      <label for="product-name">Názov produktu</label>
      <input type="text" name="product-name" required value="{{$product->name}}">
    </div>

    <div class="add-form-input">
      <label for="product-description">Popis</label>
      <br>
      <textarea id="" name="product-description" required spellcheck="false">{{$product->description}}</textarea>
    </div>

    <div class="add-form-input">
      <label for="product-price">Cena</label>
      <input type="text" name="product-price" min="0" placeholder="0.00€" required value="{{$product->price}}">
    </div>

    <div class="add-form-input">
      <label for="product-sale-price">Zľavnena cena</label>
      <input type="text" name="product-sale-price" min="0" placeholder="0.00€" required value="{{$product->salePrice}}">
    </div>

    <div class="add-form-input">
      <label for="product-manufacturer">Výrobca</label>
      <input type="text" name="product-manufacturer" required value="{{$product->manufacturer}}">
    </div>

    <div class="add-form-input">
      <label for="product-type">Typ</label>
      <input type="text" name="product-type" required value="Vysoké tenisky">
    </div>

    <div class="add-form-input">
      <label for="product-color">Farba</label>
      <input type="text" name="product-color" required value="{{$product->color}}">
    </div>

    <div class="add-form-input">
      <label for="product-date">Rok vydania</label>
      <input type="number" min="1900" max="2099" step="1"
      value="{{\Carbon\Carbon::parse($product->release_date)->year}}" name="product-date" required />
    </div>

    <div class="add-form-input">
      <label for="product-gender">Pohlavie: </label>
      <select name="product-gender">
      <option value="Men" {{$product->gender == "Men" ? "selected" : ""}}>Muž</option>
      <option value="Women" {{$product->gender == "Women" ? "selected" : ""}}>Žena</option>
      <option value="Unisex" {{$product->gender == "Unisex" ? "selected" : ""}}>Unisex</option>
      </select>
    </div>


    <div class="add-form-input">
      <label for="product-size" class="size-label">Veľkosť (vyberte viacero)</label>
      <div class="size-options">
      <label><input type="checkbox" name="sizes[]" value="36" {{ in_array(36, $sizes ?? []) ? "checked" : ""}}><span>36</span></label>
      <label><input type="checkbox" name="sizes[]" value="38" {{ in_array(38, $sizes ?? []) ? "checked" : ""}}><span>38</span></label>
      <label><input type="checkbox" name="sizes[]" value="39" {{ in_array(39, $sizes ?? []) ? "checked" : ""}}><span>39</span></label>
      <label><input type="checkbox" name="sizes[]" value="40" {{ in_array(40, $sizes ?? []) ? "checked" : ""}}><span>40</span></label>
      <label><input type="checkbox" name="sizes[]" value="41" {{ in_array(41, $sizes ?? []) ? "checked" : ""}}><span>41</span></label>
      <label><input type="checkbox" name="sizes[]" value="42" {{ in_array(42, $sizes ?? []) ? "checked" : ""}}><span>42</span></label>
      <label><input type="checkbox" name="sizes[]" value="43" {{ in_array(43, $sizes ?? []) ? "checked" : ""}}><span>43</span></label>
      <label><input type="checkbox" name="sizes[]" value="44" {{ in_array(44, $sizes ?? []) ? "checked" : ""}}><span>44</span></label>
      </div>
    </div>

    <div class="flex">
      <button type="submit" class="button">Uložiť zmeny</button>
    </div>
    </form>
    <form method="POST" action="/products/{{ $product->id }}/remove" class="remove-form">
    @csrf
    <button type="submit" class="remove-button button">Odstraniť produkt</button>
    </form>
  </main>
@endsection
