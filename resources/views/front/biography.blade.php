@extends('layouts.guest')

@section('title', __('pages.biography'))

@section('metadata')
    <meta property="og:image" content="https://geoffreyturpin.fr/images/guitare.jpg" />
    <meta property="og:title" content="Geoffrey Turpin | {{ __('pages.biography') }}" />
    <meta name="twitter:title" content="Geoffrey Turpin | {{ __('pages.biography') }}">
    <meta name="twitter:description" content="{{ __('pages.meta_description') }}">
    <meta name="twitter:image" content="https://geoffreyturpin.fr/images/guitare.jpg">
@endsection

@section('content')

<main class="biography container mx-auto mt-12 md:px-5 xl:px-0">
    <section class="user">
        <!-- <img src="{{ $user->picture }}" alt="Geoffrey Turpin" /> -->
         <img src="/images/geoffrey.jpg" alt="Geoffrey Turpin" />

        <div class="description">
            <h1 class="harrison">{{ $user->name }}</h1>
            @foreach(explode("\n" , $user->description) as $p)
                @if(trim($p))
                    {!! "<p>$p</p>" !!}
                @endif
            @endforeach
        </div>
    </section>

    <section class="timeline">
        <h1 class="harrison">@lang('pages.journey')</h3>

        <ul>
            <li>
                <div>
                    <time>@lang('pages.soon')</time>
                    <p>@lang('pages.soon_desc')</p>
                </div>
            </li>

            @foreach($bio as $b)
                <li>
                    <div>
                        <time>{{ $b->year }}</time>
                        @foreach(explode("\n", $b->text) as $line)
                            @if (trim($line))
                                {!! "<p>$line</p>" !!}
                            @endif
                        @endforeach
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
</main>
@endsection
