<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('pages.meta_description') }}">

    <meta property="og:site_name" content="Geoffrey Turpin" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="{{ __('pages.landing') }}" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property=“og:image" content="https://geoffreyturpin.fr/images/guitare.jpg" />

    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Geoffrey Turpin | {{ __('pages.landing') }}">
    <meta name="twitter:description" content="{{ __('pages.meta_description') }}">
    <meta name="twitter:image" content="https://geoffreyturpin.fr/images/guitare.jpg">

    <title>Geoffrey Turpin | @lang('pages.landing')</title>

    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    @vite('resources/sass/app.scss')
    <link rel="canonical" href="{{ url()->current() }}/">
</head>

<body>
<main class="landing">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="">
    </div>
    <section class="links">
        <a href="{{ route('biography') }}">@lang('pages.discover')</a>
        <a href="{{ route('musics') }}">@lang('pages.listen')</a>
    </section>
</main>

@include('front.partials._footer')

</body>
</html>
