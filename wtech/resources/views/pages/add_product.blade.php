@extends('master')

@section('content')
  <main>
    <ol class="breadcrumb">
    <li><a href="/">Domov</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="/new">Produkty</a></li>
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
      <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
    </svg>
    <li><a href="./">Pridať produkt</a></li>
    </ol>


    <form method="POST" action="products/create" enctype="multipart/form-data" class="add-product-form">
    @csrf
    <h1>Nový produkt</h1>
    <div class="add-form-input">
      <label for="product-images">Obrázky produktu (min. 2)</label>
      <input type="file" name="product-images[]" accept="image/png, image/jpeg" required multiple />
    </div>

    <div class="add-form-input">
      <label for="product-name">Názov produktu</label>
      <input type="text" name="product-name" required value="{{ old('product-name') }}">
    </div>

    <div class="add-form-input">
      <label for="product-description">Popis</label>
      <br>
      <textarea name="product-description" required>{{ old('product-description') }}</textarea>
    </div>

    <div class="add-form-input">
      <label for="product-price">Cena</label>
      <input type="number" name="product-price" min="0" placeholder="0.00€" required value="{{ old('product-price') }}">
    </div>

    <div class="add-form-input">
      <label for="product-sale-price">Zľavnena cena</label>
      <input type="number" name="product-sale-price" min="0" placeholder="0.00€" required
      value="{{ old('product-sale-price') }}">
    </div>

    <div class="add-form-input">
      <label for="product-manufacturer">Výrobca</label>
      <input type="text" name="product-manufacturer" required value="{{ old('product-manufacturer') }}">
    </div>

    <div class="add-form-input">
      <label for="product-type">Typ</label>
      <input type="text" name="product-type" required value="{{ old('product-type') }}">
    </div>

    <div class="add-form-input">
      <label for="product-color">Farba</label>
      <input type="text" name="product-color" required value="{{ old('product-color') }}">
    </div>

    <div class="add-form-input">
      <label for="product-date">Rok vydania</label>
      <input type="number" min="1900" max="2099" step="1" name="product-date" required
      value="{{ old('product-date', 2020) }}">
    </div>

    <div class="add-form-input">
      <label for="product-gender">Pohlavie: </label>
      <select name="product-gender">
      <option value="Men" {{ old('product-gender') === 'Men' ? 'selected' : '' }}>Muž</option>
      <option value="Women" {{ old('product-gender') === 'Women' ? 'selected' : '' }}>Žena</option>
      <option value="Unisex" {{ old('product-gender') === 'Unisex' ? 'selected' : '' }}>Unisex</option>
      </select>
    </div>

    <div class="add-form-input">
      <label for="product-size" class="size-label">Veľkosť (vyberte viacero)</label>
      <div class="size-options">
      <label><input type="checkbox" name="sizes[]" value="38" {{ in_array('38', old('sizes', [])) ? 'checked' : '' }}><span>38</span></label>
      <label><input type="checkbox" name="sizes[]" value="39" {{ in_array('39', old('sizes', [])) ? 'checked' : '' }}><span>39</span></label>
      <label><input type="checkbox" name="sizes[]" value="40" {{ in_array('40', old('sizes', [])) ? 'checked' : '' }}><span>40</span></label>
      <label><input type="checkbox" name="sizes[]" value="41" {{ in_array('41', old('sizes', [])) ? 'checked' : '' }}><span>41</span></label>
      <label><input type="checkbox" name="sizes[]" value="42" {{ in_array('42', old('sizes', [])) ? 'checked' : '' }}><span>42</span></label>
      <label><input type="checkbox" name="sizes[]" value="43" {{ in_array('43', old('sizes', [])) ? 'checked' : '' }}><span>43</span></label>
      <label><input type="checkbox" name="sizes[]" value="44" {{ in_array('44', old('sizes', [])) ? 'checked' : '' }}><span>44</span></label>
      <label><input type="checkbox" name="sizes[]" value="45" {{ in_array('45', old('sizes', [])) ? 'checked' : '' }}><span>45</span></label>
      <label><input type="checkbox" name="sizes[]" value="46" {{ in_array('46', old('sizes', [])) ? 'checked' : '' }}><span>46</span></label>
      </div>
    </div>



    <button type="submit" class="button">Vytvoriť produkt</button>
    </form>


  </main>
@endsection
