@extends('admin.layouts.master')

@section('css')
<style>
  .img-preview-box img{max-height:120px;}
</style>
@endsection

@section('admin')
@php 
$locale = Session::get('locale', config('app.locale'));
@endphp
<div class="container-fluid pt-3">
  <div class="d-flex justify-content-between align-items-center">
    <h1>Home Page Editor</h1>
  </div>
</div>

<div class="container-fluid mt-3">

  @if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="icon fas fa-check mr-1"></i>
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <script>
      setTimeout(function () { $('#success-alert').alert('close'); }, 5000);
    </script>
  @endif

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Home Page Editor</h3>
    </div>

    <form action="{{ route('admin.homepage.setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="card-body">
            <div class="row">

              <div class="col-md-12">
                  <h4 class="mt-4 mb-3 border-bottom pb-2 text-primary">About Us Section</h4>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>About us title  ({{ $language->title }})</label>
                  <input type="text" name="about_us_title_home[{{ $code }}]" value="{{ old('about_us_title_home.' . $code, $setting->getDirectValue('about_us_title_home', $code)) }}" class="form-control" placeholder="Enter About us title for home  ({{ $language->title }})">
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                  <label>About us button link</label>
                  <input type="text" name="about_us_btn_home" value="{{ old('about_us_btn_home', $setting->about_us_btn_home) }}" class="form-control" placeholder="Enter About us button link for home">
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>About us content  ({{ $language->title }})</label>
                  <textarea name="about_us_content_home[{{ $code }}]" rows="2" class="form-control @error('about_us_content_home') is-invalid @enderror" placeholder="Enter About us content for home  ({{ $language->title }})">{{ old('about_us_content_home.' . $code, $setting->getDirectValue('about_us_content_home', $code)) }}</textarea>
                  @error('about_us_content_home') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-6">
                <div class="form-group">
                  <label>About us cover image for home</label>
                  <input type="file" name="about_us_cover_image_home" class="form-control @error('about_us_cover_image_home') is-invalid @enderror">
                  @error('about_us_cover_image_home') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  @if($setting->about_us_cover_image_home)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/about_us_cover_image_home/'.$setting->about_us_cover_image_home) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>About us cover image Layout</label>
                    <select name="about_us_cover_image_home_layout" class="form-control">
                        <option value="object-cover object-center" {{ $setting->about_us_cover_image_home_layout == 'object-cover object-center' ? 'selected' : '' }}>Cover (Center)</option>
                        <option value="object-cover object-top" {{ $setting->about_us_cover_image_home_layout == 'object-cover object-top' ? 'selected' : '' }}>Cover (Top)</option>
                        <option value="object-cover object-bottom" {{ $setting->about_us_cover_image_home_layout == 'object-cover object-bottom' ? 'selected' : '' }}>Cover (Bottom)</option>
                        <option value="object-contain object-center" {{ $setting->about_us_cover_image_home_layout == 'object-contain object-center' ? 'selected' : '' }}>Contain (Center)</option>
                        <option value="object-fill" {{ $setting->about_us_cover_image_home_layout == 'object-fill' ? 'selected' : '' }}>Fill (Stretch)</option>
                    </select>
                    <small class="text-muted">Choose how the image fits within its box.</small>
                </div>
              </div>


              <div class="col-md-12">
                  <h4 class="mt-4 mb-3 border-bottom pb-2 text-primary">Articles & News Section</h4>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Article & news content  ({{ $language->title }})</label>
                  <textarea name="article_news_content[{{ $code }}]" rows="2" class="form-control @error('article_news_content') is-invalid @enderror">{{ old('article_news_content.' . $code, $setting->getDirectValue('article_news_content', $code)) }}</textarea>
                  @error('article_news_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach


              <div class="col-md-12">
                  <h4 class="mt-4 mb-3 border-bottom pb-2 text-primary">Reviews Section</h4>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Review title  ({{ $language->title }})</label>
                  <input type="text" name="review_title[{{ $code }}]" value="{{ old('review_title.' . $code, $setting->getDirectValue('review_title', $code)) }}" class="form-control" placeholder="Enter Review title for home  ({{ $language->title }})">
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Review sub title  ({{ $language->title }})</label>
                  <input type="text" name="review_sub_title[{{ $code }}]" value="{{ old('review_sub_title.' . $code, $setting->getDirectValue('review_sub_title', $code)) }}" class="form-control" placeholder="Enter Review sub title for home  ({{ $language->title }})">
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Review content  ({{ $language->title }})</label>
                  <textarea name="review_content[{{ $code }}]" rows="2" class="form-control @error('review_content') is-invalid @enderror">{{ old('review_content.' . $code, $setting->getDirectValue('review_content', $code)) }}</textarea>
                  @error('review_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach


              <div class="col-md-12">
                  <h4 class="mt-4 mb-3 border-bottom pb-2 text-primary">Our Numbers (Stats) Section</h4>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Our numbers ({{ $language->title }})</label>
                  <textarea name="our_numbers_content[{{ $code }}]" rows="2" class="form-control @error('our_numbers_content') is-invalid @enderror">{{ old('our_numbers_content.' . $code, $setting->getDirectValue('our_numbers_content', $code)) }}</textarea>
                  @error('our_numbers_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>People Helped</label>
                  <input type="text" name="peaple_helped" class="form-control @error('peaple_helped') is-invalid @enderror" value="{{ old('peaple_helped', $setting->peaple_helped) }}">
                </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Volunteers</label>
                  <input type="text" name="volunteers" class="form-control @error('volunteers') is-invalid @enderror" value="{{ old('volunteers', $setting->volunteers) }}">
                </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Educated children</label>
                  <input type="text" name="educated_children" class="form-control @error('educated_children') is-invalid @enderror" value="{{ old('educated_children', $setting->educated_children) }}">
                </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Served Meal</label>
                  <input type="text" name="service_meal" class="form-control @error('service_meal') is-invalid @enderror" value="{{ old('service_meal', $setting->service_meal) }}">
                </div>
                  </div>
                </div>
              </div>


              <div class="col-md-12">
                  <h4 class="mt-4 mb-3 border-bottom pb-2 text-primary">Help People in Need Section</h4>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Help People in Need content ({{ $language->title }})</label>
                  <textarea name="help_people_need_content[{{ $code }}]" rows="2" class="form-control @error('help_people_need_content') is-invalid @enderror">{{ old('help_people_need_content.' . $code, $setting->getDirectValue('help_people_need_content', $code)) }}</textarea>
                  @error('help_people_need_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              
              <div class="col-md-12">
                <div class="form-group">
                  <label>Help People in Need button</label>
                  <input type="text" name="help_people_need_btn" class="form-control @error('help_people_need_btn') is-invalid @enderror" placeholder="https://www.example.com" value="{{ old('help_people_need_btn', $setting->help_people_need_btn) }}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Help People in Need cover image</label>
                  <input type="file" name="help_people_need_image" class="form-control @error('help_people_need_image') is-invalid @enderror">
                  @error('help_people_need_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  @if($setting->help_people_need_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/help_people_need_image/'.$setting->help_people_need_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label>Help People in Need image Layout</label>
                    <select name="help_people_need_image_layout" class="form-control">
                        <option value="object-cover object-center" {{ $setting->help_people_need_image_layout == 'object-cover object-center' ? 'selected' : '' }}>Cover (Center)</option>
                        <option value="object-cover object-top" {{ $setting->help_people_need_image_layout == 'object-cover object-top' ? 'selected' : '' }}>Cover (Top)</option>
                        <option value="object-cover object-bottom" {{ $setting->help_people_need_image_layout == 'object-cover object-bottom' ? 'selected' : '' }}>Cover (Bottom)</option>
                        <option value="object-contain object-center" {{ $setting->help_people_need_image_layout == 'object-contain object-center' ? 'selected' : '' }}>Contain (Center)</option>
                        <option value="object-fill" {{ $setting->help_people_need_image_layout == 'object-fill' ? 'selected' : '' }}>Fill (Stretch)</option>
                    </select>
                    <small class="text-muted">Choose how the image fits within its box.</small>
                </div>
              </div>


              <div class="col-md-12">
                  <h4 class="mt-4 mb-3 border-bottom pb-2 text-primary">Other Home Page Content</h4>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Start Volunteering content ({{ $language->title }})</label>
                  <textarea name="start_volunteering_content[{{ $code }}]" rows="2" class="form-control @error('start_volunteering_content') is-invalid @enderror">{{ old('start_volunteering_content.' . $code, $setting->getDirectValue('start_volunteering_content', $code)) }}</textarea>
                  @error('start_volunteering_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Become Sponsor content ({{ $language->title }})</label>
                  <textarea name="become_sponsor_content[{{ $code }}]" rows="2" class="form-control @error('become_sponsor_content') is-invalid @enderror">{{ old('become_sponsor_content.' . $code, $setting->getDirectValue('become_sponsor_content', $code)) }}</textarea>
                  @error('become_sponsor_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Download Annual Report content ({{ $language->title }})</label>
                  <textarea name="download_annual_report_content[{{ $code }}]" rows="2" class="form-control @error('download_annual_report_content') is-invalid @enderror">{{ old('download_annual_report_content.' . $code, $setting->getDirectValue('download_annual_report_content', $code)) }}</textarea>
                  @error('download_annual_report_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                  <div class="form-group">
                      <label>Download Annual Report file</label>

                      <input type="file"
                            name="download_annual_report_file"
                            class="form-control @error('download_annual_report_file') is-invalid @enderror">

                      @error('download_annual_report_file')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror

                      {{-- PREVIEW --}}
                      @if(!empty($setting->download_annual_report_file))
                          @php
                              $file = $setting->download_annual_report_file;
                              $path = asset('storage/download_annual_report_file/'.$file);
                              $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                          @endphp

                          <div class="mt-3 p-3 border rounded bg-light">

                              {{-- IMAGE --}}
                              @if(in_array($ext, ['jpg','jpeg','png','webp','gif']))
                                  <img src="{{ $path }}"
                                      class="img-fluid rounded"
                                      style="max-height:200px;"
                                      alt="Annual Report Image">

                              {{-- PDF --}}
                              @elseif($ext === 'pdf')
                                  <i class="fas fa-file-pdf text-danger fa-3x"></i>
                                  <a href="{{ $path }}" target="_blank" class="ml-2">
                                      View PDF
                                  </a>

                              {{-- CSV / EXCEL --}}
                              @elseif(in_array($ext, ['csv','xls','xlsx']))
                                  <i class="fas fa-file-excel text-success fa-3x"></i>
                                  <span class="ml-2">{{ $file }}</span>

                              {{-- OTHER FILES --}}
                              @else
                                  <i class="fas fa-file-alt fa-3x text-secondary"></i>
                                  <span class="ml-2">{{ $file }}</span>
                              @endif

                              {{-- DOWNLOAD BUTTON --}}
                              <div class="mt-2">
                                  <a href="{{ $path }}"
                                    class="btn btn-sm btn-outline-primary"
                                    download>
                                      <i class="fas fa-download"></i> Download
                                  </a>
                              </div>

                          </div>
                      @endif
                  </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Contact us button link (Volunteers)</label>
                  <input type="text" name="contact_us_button_volun" class="form-control @error('contact_us_button_volun') is-invalid @enderror" placeholder="https://www.example.com" value="{{ old('contact_us_button_volun', $setting->contact_us_button_volun) }}">
                </div>
              </div>

            </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>
@endsection
