@section('title', 'Connexion')

<x-auth-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h3 class="harrison">Connexion</h3>

        @if($errors->any())
            <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="control">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
            <input type="password" name="password" placeholder="Mot de passe" value="{{ old('password') }}" required>
        </section>

        <section class="actions">
            <a href="{{ route('password.request') }}">Mot de passe oublié</a>
            <button type="submit">Connexion</button>
        </section>
    </form>
</x-auth-layout>
