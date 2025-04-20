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
            </ol>
        </nav>

        <section class="container">
            <h1>Prihlásenie</h1>
            <form class="login-form">
                <div>
                    <label for="email">Email</label>
                    <input type="text" name="email" required />
                </div>
                <div>
                    <label for="password">Heslo</label>
                    <input type="password" name="password" required />
                </div>
                <button type="submit">Prihlásiť sa</button>
            </form>
            <p>Zabudli ste heslo? <a href="/renew_password">Obnoviť heslo</a></p>
            <p>Nemáte účet? <a href="/register">Registrovať sa</a></p>
        </section>
    </main>
@endsection
