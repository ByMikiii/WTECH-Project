@extends('master')

@section('content')
    <main>
        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li><a href="/">Domov</a></li>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
                </svg>
                <li><a href="/login">Prihlásenie</a></li>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z" />
                </svg>
                <li><a href="/reset_password">Obnova hesla</a></li>
            </ol>
        </nav>

        <section class="container">
            <h1>Obnova hesla</h1>
            <form class="login-form" method="POST" action="{{ route('password.update') }}">
            @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label for="password">Nové heslo</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation">Zopakuj heslo</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <button type="submit">Zmeniť heslo</button>
            </form>
        </section>
    </main>
@endsection
