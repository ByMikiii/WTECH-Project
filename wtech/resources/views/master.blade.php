<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ '/images/favicon.png' }}" type="image/x-icon">
    <title>{{ $title ?? 'NaNohu' }}</title>
    @if (str_ends_with($title, ' - NaNohu'))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
