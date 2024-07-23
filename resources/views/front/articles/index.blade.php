@extends('layouts.guest')

@section('title', 'Articles')

@section('metadata')
    <meta property="og:image" content="https://geoffreyturpin.fr/images/guitare.jpg" />
    <meta property="og:title" content="Geoffrey Turpin | Articles }}" />
    <meta name="twitter:title" content="Geoffrey Turpin | Articles }}">
    <meta name="twitter:description" content="{{ __('pages.meta_description') }}">
    <meta name="twitter:image" content="https://geoffreyturpin.fr/images/guitare.jpg">
@endsection

@section('content')
    <section class="articles container mx-auto mt-12 md:px-5 xl:px-0">
        <h1 class="harrison">@lang('articles.index')</h1>

        <div class="tags">
            @if(count($tags) > 0)
            <p>Tags :</p>
            <div>
                @foreach($tags as $tag)
                    <a href="{{ url()->current() . '?tag=' . $tag->slug }}">{{ $tag->name }}</a>
                @endforeach
            </div>
            @endif
        </div>

        <div class="content">
            @if(count($articles) > 0)
                @foreach($articles as $article)
                    <article class="post">
                        <div class="post-body">
                            <a href="{{ route('article.show', $article->slug) }}">
                                <img src="{{ $article->getFirstMediaUrl('banner', 'thumbnail') }}" alt="{{ $article->title }}">
                            </a>
                            <div class="details">
                                <div class="taxo">
                                    @foreach($article->tags()->get() as $i => $tag )
                                        <a href="{{ url()->current() . '?tag=' . $tag->slug }}">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <h2>
                                    <a href="{{ route('article.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h2>
                                <p>
                                    {{ strip_tags(substr($article->content, 0, strpos($article->content, ' ', 200))) }}...
                                </p>
                                <p class="date">
                                    @lang('articles.the') <time datetime="{{ $article->updated_at }}">
                                        {{ date('d/m/Y', strtotime($article->updated_at)) }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            @else
                <h2 class="harrison text-center">
                    @lang('articles.none')
                </h2>
            @endif
        </div>
    </section>
@endsection
