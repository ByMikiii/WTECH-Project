@extends('master')

@section('content')
    <main>
        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li><a href="/">Domov</a></li>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
                </svg>
                <li><a href="/profile">Profil</a></li>
            </ol>
        </nav>

        <section id="logout_button">
            <button id="logout">Odhlásiť sa</button>
        </section>

        <section class="profile">
            <h1>Profil používateľa</h1>
            <div>
                <label for="name">Meno</label>
                <span name="name">{{ $name }}</span>
            </div>
            <div>
                <label for="e-mail">E-mail</label>
                <span name="e-mail">{{ $email }}</span>
            </div>
            <div>
                <label for="phone">Telefónne číslo</label>
                <span name="phone">{{ $phone }}</span>
            </div>
            <div>
                <label for="address">Adresa</label>
                <span name="address">{{ $address }}</span>
            </div>
            <button onclick="location.href='/edit_profile';">Upraviť profil</button>
            <button onclick="location.href='/change_password';">Zmena hesla</button>
        </section>
    </main>
@endsection
