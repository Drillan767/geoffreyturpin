<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="{{ url()->current() }}/">

    <meta property="og:site_name" content="Geoffrey Turpin" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    @yield('metadata')

    <title>{{ config('app.name') }} | @yield('title')</title>

    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    @vite('resources/sass/app.scss')

</head>
<body>
<nav class="nav">
    <div class="nav-responsive">
        <div class="nav-brand">
            <a href="{{ route('home') }}">
                <img src="/images/logo.png" alt="logo">
            </a>
        </div>

        <input class="menu-btn hidden" type="checkbox" id="menu-btn">
        <label class="menu-icon block cursor-pointer lg:hidden px-2 py-4 relative select-none" for="menu-btn">
            <span class="navicon bg-grey-darkest flex items-center relative"></span>
        </label>
    </div>

    <div class="nav-link">
        <a href="{{ route('biography') }}" @if(str_contains(Route::currentRoutename(), 'biography'))class="current"@endif>
            {{ __('pages.biography') }}
        </a>

        <a href="{{ route('musics') }}" @if(str_contains(Route::currentRoutename(), 'musics'))class="current"@endif>
            {{ __('pages.musics') }}
        </a>

        <a href="{{ route('articles') }}" @if(in_array(Route::currentRoutename(), [
            app()->getLocale() . '.article.show',
            app()->getLocale() . '.articles'
            ]))class="current"@endif>
            {{ __('pages.articles') }}
        </a>

        <a href="{{ route('contact') }}" @if(str_contains(Route::currentRoutename(), 'contact'))class="current"@endif>
            {{ __('pages.contact') }}
        </a>
    </div>

    <div class="nav-end">
        @foreach(['facebook', 'youtube', 'linkedin'] as $url)
            <a href="{{ $user->$url }}" target="_blank">
                <img src="{{ asset("/images/$url.png") }}" alt="{{ $url }}">
            </a>
        @endforeach
    </div>
</nav>

<hr />

<div class="font-sans text-gray-900 antialiased">
    @yield('content')
</div>

<hr />
@include('front.partials._footer')

<script>
    const checkbox = document.querySelector('.menu-btn.hidden');
    const navLink = document.querySelector('.nav-link');
    const navEnd = document.querySelector('.nav-end');
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            navLink.classList.add('show');
            navEnd.classList.add('show');
        } else {
            navLink.classList.remove('show');
            navEnd.classList.remove('show');
        }
    })
</script>
</body>
</html>
