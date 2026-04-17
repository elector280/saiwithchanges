<div class="modal fade" id="modal-default-{{ $img->id }}">
  <div class="modal-dialog">
    <form class="modal-content" method="POST"
          action="{{ route('campaign.gallery.update', [$campaign, $img]) }}"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Image</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">

        {{-- Preview --}}
        <div class="mb-3">
          <img src="{{ asset('storage/gallery_image/'.$img->image) }}"
               class="border rounded img-fluid edit-preview-img"
               style="width:100%; max-height:260px; object-fit:cover;">
        </div>

       @foreach(App\Models\Language::where('active',1)->get() as $language)
        @if ($language->language_code === $locale)
            @php $langCode = $language->language_code;  @endphp

            <div class="form-group">
                <label>Title ({{ $language->title }})</label>
                <input type="text"
                    name="title[{{ $langCode }}]"
                    value="{{ old('title.' . $langCode, $img->getTitle($langCode)) }}"
                    class="form-control" required>
            </div>

            <div class="form-group"> 
                <label>Alt Text ({{ $language->title }})</label>
                <input type="text" name="alt_text[{{ $langCode }}]"
                    value="{{ old('alt_text.' . $langCode, $img->getDirectValue('alt_text', $langCode)) }}"
                    class="form-control" required>
            </div>
            <div class="form-group">
                <label>Captions ({{ $language->title }})</label>
                <input type="text" name="caption[{{ $langCode }}]"
                    value="{{ old('caption.' . $langCode, $img->getDirectValue('caption', $langCode)) }}"
                    class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tags ({{ $language->title }})</label>
                <input type="text" name="tags[{{ $langCode }}]"
                    value="{{ old('tags.' . $langCode, $img->getDirectValue('tags', $langCode)) }}"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label>Description ({{ $language->title }})</label>
                <textarea name="description[{{ $langCode }}]"
                        class="form-control" required>{{ old('description.' . $langCode, $img->getDescription($langCode)) }}</textarea>
            </div>
          @endif
        @endforeach




        <div class="form-group">
          <label>Replace image (optional)</label>
          <input type="file" name="image" class="form-control" accept="image/*">
          <small class="text-muted">Max 5MB (leave empty to keep current)</small>
        </div>
        <div class="form-group">
            <label>Image SEO Url (Slug)</label>
            <input type="text" name="slug" class="form-control" value="{{ $img->slug }}" placeholder="e.g. sai-children" required>
        </div>

        <div class="form-group">
            <label>Image Credit / Copyright</label>
            <input type="text" name="credit_copyrights" class="form-control" value="{{ $img->credit_copyrights }}" placeholder="Image Credit / Copyright" required>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>

    </form>
  </div>
</div>
