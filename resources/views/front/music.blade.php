@extends('layouts.guest')

@section('title', __('pages.musics'))

@section('metadata')
    <meta property="og:image" content="https://geoffreyturpin.fr/images/guitare.jpg" />
    <meta property="og:title" content="Geoffrey Turpin | {{ __('pages.musics') }}" />
    <meta name="twitter:title" content="Geoffrey Turpin | {{ __('pages.musics') }}">
    <meta name="twitter:description" content="{{ __('pages.meta_description') }}">
    <meta name="twitter:image" content="https://geoffreyturpin.fr/images/guitare.jpg">
@endsection

@section('content')

    <main class="music">
        <div class="control">
            <div class="compoimage selected">
                <span>@lang('pages.compoimage')</span>
            </div>
            <div class="puremusic">
                <span>@lang('pages.puremusic')</span>
            </div>
        </div>

        <section>
            <div class="carousel">
                <div class="card">
                    <div class="container">
                        <h1 class="harrison">@lang('pages.compoimage2')</h1>

                        @foreach($musics as $music)
                            <div class="image">
                                <div class="iframe">
                                    {!! $music->iframe !!}
                                </div>
                                <div class="description">
                                    <p class="image-title">{{ $music->title }}</p>
                                    <p class="image-author">{{ $music->author }} - {{ $music->year }}</p>
                                    @if($music->subtitle)
                                        <p class="music-subtitle">{{ $music->subtitle }}</p>
                                    @endif

                                    @foreach(explode("\n", $music->content) as $line)
                                        @if(trim($line))
                                            {!! "<p>$line</p>" !!}
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="card">
                    <div class="container">
                        <h2 class="harrison">@lang('pages.puremusic')</h2>
                        <iframe width="100%" height="450" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/playlists/172592426&color=%23000000&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function() {
            const carousel = document.querySelector('.carousel');
            const image = document.querySelector('.compoimage');
            const music = document.querySelector('.puremusic');

            image.addEventListener('click', () => {
                if (! image.classList.contains('selected')) {
                    carousel.style.transform = "translateX(0)"
                    image.classList.add('selected');
                    music.classList.remove('selected');
                }
            });

            music.addEventListener('click', () => {
                if (! music.classList.contains('selected')) {
                    carousel.style.transform = "translateX(-100%)";
                    music.classList.add('selected');
                    image.classList.remove('selected');
                }
            });
        })()
    </script>

@endsection
