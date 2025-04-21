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
            <div>
                <span>
                    <img class="cart-image" src="../images/optimized_products/air-jordan-1-retro-high-og-travis-scott/1.jpg"
                        alt="Air Jordan 1">
                </span>
                <span>
                    Air Jordan 1 Retro High OG "Travis Scott"
                </span>
                <span>
                    <button onclick="this.nextElementSibling.stepDown()">−</button>
                    <input type="number" value="1" placeholder="1" required>
                    <button onclick="this.previousElementSibling.stepUp()">+</button>
                </span>
                <span>
                    <button onclick="this.nextElementSibling.stepDown()">−</button>
                    <input type="number" value="40" placeholder="40" required>
                    <button onclick="this.previousElementSibling.stepUp()">+</button>
                </span>
                <span>
                    899,99€
                </span>
                <span>
                    <button>X</button>
                </span>
            </div>
            <div>
                <span>
                    <img class="cart-image" src="../images/optimized_products/nike-air-max-1-97-sean-wotherspoon/1.jpg"
                        alt="Nike Air Max 1/97 'Sean Wotherspoon">
                </span>
                <span>
                    Nike Joyride Run Flyknit
                </span>
                <span>
                    <button onclick="this.nextElementSibling.stepDown()">−</button>
                    <input type="number" value="1" placeholder="1" required>
                    <button onclick="this.previousElementSibling.stepUp()">+</button>
                </span>
                <span>
                    <button onclick="this.nextElementSibling.stepDown()">−</button>
                    <input type="number" value="40" placeholder="40" required>
                    <button onclick="this.previousElementSibling.stepUp()">+</button>
                </span>
                <span>
                    149,99€
                </span>
                <span>
                    <button>X</button>
                </span>
            </div>

            <button onclick="location.href='order.html';">Prejsť na objednávku</button>
        </section>


    </main>
@endsection
