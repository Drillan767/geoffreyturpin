@extends('layouts.guest')

@section('title', 'Articles')

@section('metadata')
    <meta name="description" content="{{ substr($article->content, 145) . '...' }}">
    <meta name="og:description" content="{{ substr($article->content, 145) . '...' }}">
    <meta property="og:image" content="{{ $article->getFirstMediaUrl('banner') }}" />
    <meta property="og:title" content="Geoffrey Turpin | {{ $article->title }} }}" />
    <meta name="twitter:title" content="Geoffrey Turpin | {{ $article->title }} }}">
    <meta name="twitter:description" content="{{ substr($article->content, 145) . '...' }}">
    <meta name="twitter:image" content="{{ $article->getFirstMediaUrl('banner') }}">
    <meta property="og:type" content="article" />
@endsection

@section('content')
    <div class="article">
        <div class="banner" style="background-image: url('{{ $article->getFirstMediaUrl('banner') }}')"></div>
        <article class="container mx-auto mt-12 md:px-5 xl:px-0">
            <h1>{{ $article->title }}</h1>
            <p class="time">@lang('articles.updated')
                <time datetime="{{ $article->updated_at }}">
                    {{ date('d/m/Y', strtotime($article->updated_at)) }}
                </time>
            </p>

            <div class="content">
                {!! $article->content !!}
            </div>

            <div class="tags">
                @foreach($article->tags()->get() as $i => $tag )
                    <a href="{{ url()->current() . '?tag=' . $tag->slug }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        </article>
    </div>
@endsection
