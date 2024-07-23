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
        <contact-form></contact-form>
    </main>
@endsection
