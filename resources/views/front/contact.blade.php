@extends('layouts.guest')

@section('title', 'Contact')

@section('metadata')
    <meta property="og:image" content="https://geoffreyturpin.fr/images/guitare.jpg" />
    <meta property="og:title" content="Contact">
    <meta name="twitter:title" content="Geoffrey Turpin | Contact">
    <meta name="twitter:description" content="{{ __('pages.meta_description') }}">
    <meta name="twitter:image" content="https://geoffreyturpin.fr/images/guitare.jpg">
@endsection

@section('content')
    <main class="contact">
        <h1 class="harrison">Contact</h1>
        <form method="POST" action="/contact">
            @if($errors->any())
                <div class="errors">
                    <ul>
                        {!! implode('', $errors->all('<li>:message</li>')) !!}
                    </ul>
                </div>
            @endif

            @csrf
            <div class="control">
                <input type="text" name="name" placeholder="{{ __('contact.name') }}" />
            </div>
            <div class="control">
                <input type="email" name="email" placeholder="{{ __('contact.email') }}" />
            </div>
            <div class="control">
                <input type="text" name="subject" placeholder="{{ __('contact.subject') }}" />
            </div>
            <div class="control">
                <textarea cols="30" rows="5" placeholder="{{ __('contact.message') }}" name="message" required></textarea>
            </div>
            <div class="tos">
                <input id="tos" type="checkbox" name="tos"  />
                <label for="tos">You accept the terms of services</label>
            </div>
            <div class="actions">
                <button type="submit">{{ __('contact.send') }}</button>
            </div>
        </form>
    </main>
@endsection
