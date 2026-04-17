 @php
    $currentLocale = session('locale', config('app.locale'));
    $languages = App\Models\Language::where('active', 1)->get();
@endphp

<div class="btn-group btn-group-sm mr-2" role="group" aria-label="Language toggle">

    @foreach ($languages as $language)
        <form action="{{ route('languageUpdateStatus', $language) }}" method="POST">
            @csrf

            <button
                type="submit"
                class="btn btn-sm
                    {{ $currentLocale === $language->language_code 
                        ? 'btn-primary' 
                        : 'btn-outline-primary' }}">
                {{ strtoupper($language->language_code) }}
            </button>
        </form>
    @endforeach

</div>