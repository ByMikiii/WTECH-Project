<nav id="main-nav">
  <button id="nav-toggle" onclick="toggleMobileNav()">
    <svg width="40" height="40" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M4.75 5.75H19.25"></path>
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
        d="M4.75 18.25H19.25"></path>
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.75 12H19.25">
      </path>
    </svg>
  </button>
  <a class="logo" href="/"><img class="logo" src="../images/logo.png" alt="Logo"></a>
  <ul id="center-nav">
    <li><a href="/new">Novinky</a></li>
    <li><a href="/men">Muži</a></li>
    <li><a href="/women">Ženy</a></li>
    <li><a href="/sale">Výpredaj</a></li>
    @if (!Auth::check())
    <li><span class="login-nav">|</span></li>
    <li><a href="/login">Prihlásiť sa</a></li>
  @elseif (Auth::check() && Auth::user()->role == 'admin')
    <li><span class="login-nav">|</span></li>
    <li><a href="/all">Všetky produkty</a></li>
  @endif

  </ul>
  <ul id="right-nav">
    @if (Auth::check())
    <li class="li-icons"><a href="/profile"><img id="profile-icon" src="../images/Profile Icon.png"
        alt="Profile Icon"></a>
    </li>
  @endif
    <li><a href="/cart"><img id="cart-icon" src="../images/Cart Shopping Bag.png" alt="Cart Icon"></a></li>
  </ul>
</nav>
<hr>
<nav id="mobile-nav">
  <ul>
    <li><a href="/new">Novinky</a></li>
    <hr>
    <li><a href="/men">Muži</a></li>
    <hr>
    <li><a href="/women">Ženy</a></li>
    <hr>
    <li><a href="/sale">Výpredaj</a></li>
    <hr>
    @if (Auth::check() && Auth::user()->role == 'admin')
    <li><a href="/all">Všetky produkty</a></li>
    <hr>
  @endif
    @if (Auth::check())
    <li><a href="/profile">Profil</a></li>
    <hr>
  @else
    <li><a href="/login">Prihlásiť sa</a></li>
    <hr>
    <li><a href="/register">Zaregistrovať sa</a></li>
    <hr>
  @endif
  </ul>
</nav>
@if (!request()->is('login', 'register', 'reset_password/*', 'profile', 'change_password', 'edit_profile', 'cart', 'order', 'summary', 'card_pay', 'bank_pay', 'forgot_password'))
  <form method="GET" action="/filter" class="search-form" id="search-form">
    <input type="text" name="search" class="search-input" placeholder="Vyhladať..." @if (!empty($search))
  value="{{ $search }}" @endif>
    <button type="submit" class="search-submit"><img class="search-icon" src="../images/Search Icon.png"
      alt="Search Icon"></button>
  </form>
@endif
