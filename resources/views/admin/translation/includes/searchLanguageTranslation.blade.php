<table class="table table-striped table-bordered" id="" width="100%">
    <thead>
        <tr>
            <th width="5%">#Sl</th>
            <th width="40%">Key</th>
            <th width="55%">Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lang_keys as $key => $translation)
            <tr>
                <td>{{ ($key+1) + ($lang_keys->currentPage() - 1)*$lang_keys->perPage() }}</td>
                <td class="key">{{ucwords(str_replace('_', ' ', $translation->lang_key))}}</td>
                <td>
                    <input type="text" class="form-control value" style="width:100%" name="values[{{ $translation->lang_key }}]" @if (($traslate_lang = App\Models\LanguageTranslation::where('lang', $language->language_code)->where('lang_key', $translation->lang_key)->latest()->first()) != null)
                        value="{{ $traslate_lang->lang_value }}"
                    @endif>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>