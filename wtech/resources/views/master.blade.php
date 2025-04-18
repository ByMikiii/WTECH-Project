<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ '/images/favicon.png' }}" type="image/x-icon">
    <title>{{ $title ?? 'NaNohu' }}</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>

<body>
    <header>
        @include('components.header')
    </header>

    @yield('content')

    <footer>
        @include('components.footer')
    </footer>
</body>

</html>
