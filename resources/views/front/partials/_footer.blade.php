<footer>
    <div class="flex flex-col md:flex-row">
        <div class="md:w-3/4">
            <p>
                {{ $user->email }}
            </p>
        </div>
        <div class="md:w-1/4 flex md:justify-evenly">
            <a href="{{ route('legal') }}" class="mr-5 md:mr-0">@lang('pages.lm')</a>
            <a href="{{ Route::localizedUrl(app()->getLocale() === 'en' ? 'fr' : 'en') }}">
                {{ app()->getLocale() == 'en' ? 'Français' : 'English' }}
            </a>
        </div>
    </div>
</footer>
