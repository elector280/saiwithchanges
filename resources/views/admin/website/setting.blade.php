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
    <h1>Website setting</h1>
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
      <h3 class="card-title">Website setting</h3>
    </div>

    <form action="{{ route('setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="card-body">

        {{-- ✅ TABS HEADER --}}
        <ul class="nav nav-tabs" id="settingTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="tab-general" data-toggle="pill" href="#pane-general" role="tab" aria-controls="pane-general" aria-selected="true">
              <i class="fas fa-cog mr-1"></i> General
            </a>
          </li>


          <li class="nav-item">
            <a class="nav-link" id="tab-about" data-toggle="pill" href="#pane-about" role="tab" aria-controls="pane-about" aria-selected="false">
              <i class="fas fa-info-circle mr-1"></i> About
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="tab-contact" data-toggle="pill" href="#pane-contact" role="tab" aria-controls="pane-contact" aria-selected="false">
              <i class="fas fa-phone-alt mr-1"></i> Contact
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="tab-contact" data-toggle="pill" href="#donor_advised" role="tab" aria-controls="donor_advised" aria-selected="false">
              <i class="fas fa-copy mr-2"></i> Donor Advised Funds 
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="tab-contact" data-toggle="pill" href="#donor_in_cripto" role="tab" aria-controls="donor_in_cripto" aria-selected="false">
              <i class="fas fa-copy mr-2"></i> Donor in cripto
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="tab-contact" data-toggle="pill" href="#employee_matching_page" role="tab" aria-controls="employee_matching_page" aria-selected="false">
              <i class="fas fa-copy mr-2"></i> Employee matching page
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="tab-contact" data-toggle="pill" href="#donate" role="tab" aria-controls="donate" aria-selected="false">
              <i class="fas fa-copy mr-2"></i> Donate
            </a>
          </li>
        </ul>

        {{-- ✅ TABS BODY --}}
        <div class="tab-content border-left border-right border-bottom p-3" id="settingTabsContent">

          {{-- ================= GENERAL ================= --}}
          <div class="tab-pane fade show active" id="pane-general" role="tabpanel" aria-labelledby="tab-general">

            <div class="row">
              {{-- Title --}}
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                    @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>SEO Title ({{ $language->title }})</label>
                  <input type="text" name="title[{{ $code }}]" placeholder="Enter website title ({{ $language->title }})"
                        value="{{ old('title.' . $code, $setting->getDirectValue('title', $code)) }}" 
                        class="form-control @error('title') is-invalid @enderror">
                </div>
              </div>
              @endforeach

              {{-- Subtitle --}}
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Meta Description ({{ $language->title }})</label>
                  <textarea name="subtitle[{{ $code }}]" rows="2" class="form-control">{{ old('subtitle.' . $code, $setting->getDirectValue('subtitle', $code)) }}</textarea>
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Meta Keyword ({{ $language->title }})</label>
                  <textarea name="meta_keyword[{{ $code }}]" rows="2" class="form-control">{{ old('meta_keyword.' . $code, $setting->getDirectValue('meta_keyword', $code)) }}</textarea>
                </div>
              </div>
              @endforeach

              {{-- Description --}}
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Footer Description  ({{ $language->title }})</label>
                  <textarea name="description[{{ $code }}]" rows="3" class="form-control">{{ old('description.' . $code, $setting->getDirectValue('description', $code)) }}</textarea>
                </div>
              </div>
              @endforeach

              {{-- Email --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email"
                        value="{{ old('email', $setting->email) }}"
                        class="form-control @error('email') is-invalid @enderror">
                  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              {{-- Social Links --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Facebook URL</label>
                  <input type="url" name="fb_url" value="{{ old('fb_url', $setting->fb_url) }}" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>YouTube URL</label>
                  <input type="url" name="youtube_url" value="{{ old('youtube_url', $setting->youtube_url) }}" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Twitter URL</label>
                  <input type="url" name="twitter_url" value="{{ old('twitter_url', $setting->twitter_url) }}" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Instagram URL</label>
                  <input type="url" name="instragram_url" value="{{ old('instragram_url', $setting->instragram_url) }}" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Google Analytics Tracking ID</label>
                  <input type="text" name="google_analytics_code"
                        value="{{ old('google_analytics_code', $setting->google_analytics_code) }}"
                        class="form-control @error('google_analytics_code') is-invalid @enderror"
                        placeholder="Google Analytics Tracking ID">
                  @error('google_analytics_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              {{-- Contact --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>WhatsApp Number</label>
                  <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" class="form-control">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Telephone</label>
                  <input type="text" name="telephone" value="{{ old('telephone', $setting->telephone) }}" class="form-control">
                </div>
              </div>

              {{-- Address --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Address</label>
                  <textarea name="address" rows="2" class="form-control">{{ old('address', $setting->address) }}</textarea>
                </div>
              </div>

              {{-- Logo --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Website Logo</label>
                  <input type="file" name="logo" class="form-control">
                  @if($setting->logo)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/logo/'.$setting->logo) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div> 

              {{-- Logo Alt --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Logo Alt</label>
                  <input type="file" name="logo_alt" class="form-control">
                  @if($setting->logo_alt)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/logo_alt/'.$setting->logo_alt) }}" class="img-thumbnail" style="max-height:90px;">
                    </div>
                  @endif
                </div>
              </div>

              {{-- Favicon --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Favicon</label>
                  <input type="file" name="favicon" class="form-control">
                  @if($setting->favicon)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/favicon/'.$setting->favicon) }}" class="img-thumbnail" style="max-height:60px;">
                    </div>
                  @endif
                </div>
              </div>

            </div>
          </div>


          {{-- ================= ABOUT ================= --}}
          <div class="tab-pane fade" id="pane-about" role="tabpanel" aria-labelledby="tab-about">
            <div class="row">

              {{-- ===== SEO BLOCK ABOUT ===== --}}
              <div class="col-md-12">
                <div class="alert alert-info mb-3">
                  <strong><i class="fas fa-search mr-1"></i> SEO — About Us page</strong>
                  <p class="mb-0 small">These fields control the <code>&lt;title&gt;</code> and <code>&lt;meta description&gt;</code> that Google shows for the <strong>About Us</strong> page.</p>
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label><i class="fas fa-tag mr-1"></i> SEO Page Title ({{ $language->title }}) <small>(about us)</small></label>
                  <input type="text" name="seo_title_about[{{ $code }}]"
                         value="{{ old('seo_title_about.' . $code, $setting->getDirectValue('seo_title_about', $code)) }}"
                         class="form-control" placeholder="e.g. About Us | South American Initiative ({{ $language->title }})">
                  <small class="text-muted">Recommended: max 60 characters</small>
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label><i class="fas fa-align-left mr-1"></i> SEO Meta Description ({{ $language->title }}) <small>(about us)</small></label>
                  <textarea name="seo_description_about[{{ $code }}]" rows="2" class="form-control"
                            placeholder="Short description for Google search results ({{ $language->title }})">{{ old('seo_description_about.' . $code, $setting->getDirectValue('seo_description_about', $code)) }}</textarea>
                  <small class="text-muted">Recommended: max 160 characters</small>
                </div>
              </div>
              @endforeach

              <div class="col-md-12"><hr class="my-3"></div>
              {{-- ===== END SEO BLOCK ===== --}}

            @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>About us Title ({{ $language->title }}) <small>(about us)</small></label>
                  <input type="text" name="about_us_title[{{ $code }}]" value="{{ old('about_us_title.' . $code, $setting->getDirectValue('about_us_title', $code)) }}" class="form-control @error('about_us_title') is-invalid @enderror">
                  @error('about_us_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                  <label>About us cover image <small>(about us)</small></label>
                  <input type="file" name="about_us_cover_image" class="form-control @error('about_us_cover_image') is-invalid @enderror">
                  @error('about_us_cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  @if($setting->about_us_cover_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/about_us_cover_image/'.$setting->about_us_cover_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Our Mission content  ({{ $language->title }}) <small>(about us)</small></label>
                  <textarea name="our_mission[{{ $code }}]" rows="2" class="form-control @error('our_mission') is-invalid @enderror">{{ old('our_mission.' . $code, $setting->getDirectValue('our_mission', $code)) }}</textarea>
                  @error('our_mission') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Donate to Orphans Program content  ({{ $language->title }}) <small>(about us)</small></label>
                  <textarea name="donate_orphans_content[{{ $code }}]" rows="2" class="form-control @error('donate_orphans_content') is-invalid @enderror">{{ old('donate_orphans_content.' . $code, $setting->getDirectValue('donate_orphans_content', $code)) }}</textarea>
                  @error('donate_orphans_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Urgent help title  ({{ $language->title }})<small>(about us)</small></label>
                  <input type="text" name="urgent_help_title[{{ $code }}]" value="{{ old('urgent_help_title.' . $code, $setting->getDirectValue('urgent_help_title', $code)) }}" class="form-control @error('urgent_help_title') is-invalid @enderror">
                  @error('urgent_help_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              
              <div class="col-md-12">
                <div class="form-group">
                  <label>Urgent help image <small>(about us)</small></label>
                  <input type="file" name="urgent_help_image" class="form-control @error('urgent_help_image') is-invalid @enderror">
                  @error('urgent_help_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  @if($setting->urgent_help_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/urgent_help_image/'.$setting->urgent_help_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Urgent help description  ({{ $language->title }})<small>(about us)</small></label>
                  <textarea name="urgent_help_description[{{ $code }}]" rows="2" class="form-control @error('urgent_help_description') is-invalid @enderror">{{ old('urgent_help_description.' . $code, $setting->getDirectValue('urgent_help_description', $code)) }}</textarea>
                  @error('urgent_help_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              {{-- about images 1-4 --}}
              @for($i=1; $i<=4; $i++)
                @php $field = "about_us_image_{$i}"; @endphp
                <div class="col-md-12">
                  <div class="form-group">
                    <label>About us image {{ $i }} <small>(about us)</small></label>
                    <input type="file" name="{{ $field }}" class="form-control @error($field) is-invalid @enderror">
                    @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if($setting->$field)
                      <div class="img-preview-box mt-2">
                        <img src="{{ asset('storage/'.$field.'/'.$setting->$field) }}" class="img-thumbnail">
                      </div>
                    @endif
                  </div>
                </div>
              @endfor

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Annual report content  ({{ $language->title }}) <small>(about us)</small></label>
                  <textarea name="annual_report_content[{{ $code }}]" rows="2" class="form-control @error('annual_report_content') is-invalid @enderror">{{ old('annual_report_content.' . $code, $setting->getDirectValue('annual_report_content', $code)) }}</textarea>
                  @error('annual_report_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label> DONATE to FEEDING DREAM Btn likn  ({{ $language->title }}) <small>(about us)</small></label>
                   <input type="text" name="donate_to_feeding_dream[{{ $code }}]" class="form-control @error('donate_to_feeding_dream') is-invalid @enderror"  value="{{ old('donate_to_feeding_dream.' . $code, $setting->getDirectValue('donate_to_feeding_dream', $code)) }}" placeholder="httpa:\\www.example.com">
                  @error('donate_to_feeding_dream') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label> Donate to Orphans Program Btn likn ({{ $language->title }}) <small>(about us)</small></label>
                   <input type="text" name="donate_to_orphan_program[{{ $code }}]" class="form-control @error('donate_to_orphan_program') is-invalid @enderror"  value="{{ old('donate_to_orphan_program.' . $code, $setting->getDirectValue('donate_to_orphan_program', $code)) }}" placeholder="httpa:\\www.example.com">
                  @error('donate_to_orphan_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                  <label>Annual report cover image <small>(about us)</small></label>
                  <input type="file" name="anual_report_cover_img" class="form-control @error('anual_report_cover_img') is-invalid @enderror">
                  @error('anual_report_cover_img') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  @if($setting->anual_report_cover_img)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/anual_report_cover_img/'.$setting->anual_report_cover_img) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Annual report button <small>(about us)</small></label>
                  <input type="text" name="anual_report_button" class="form-control @error('anual_report_button') is-invalid @enderror" value="{{ old('anual_report_button', $setting->anual_report_button) }}">
                  @error('anual_report_button') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

            </div>
          </div>

          {{-- ================= Donor Advised Funds ================= --}}
          <div class="tab-pane fade" id="pane-contact" role="tabpanel" aria-labelledby="tab-contact">
            <div class="row">

              {{-- ===== SEO BLOCK CONTACT ===== --}}
              <div class="col-md-12">
                <div class="alert alert-info mb-3">
                  <strong><i class="fas fa-search mr-1"></i> SEO — Contact Us page</strong>
                  <p class="mb-0 small">These fields control the <code>&lt;title&gt;</code> and <code>&lt;meta description&gt;</code> that Google shows for the <strong>Contact Us</strong> page.</p>
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label><i class="fas fa-tag mr-1"></i> SEO Page Title ({{ $language->title }}) <small>(contact us)</small></label>
                  <input type="text" name="seo_title_contact[{{ $code }}]"
                         value="{{ old('seo_title_contact.' . $code, $setting->getDirectValue('seo_title_contact', $code)) }}"
                         class="form-control" placeholder="e.g. Contact Us | South American Initiative ({{ $language->title }})">
                  <small class="text-muted">Recommended: max 60 characters</small>
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label><i class="fas fa-align-left mr-1"></i> SEO Meta Description ({{ $language->title }}) <small>(contact us)</small></label>
                  <textarea name="seo_description_contact[{{ $code }}]" rows="2" class="form-control"
                            placeholder="Short description for Google search results ({{ $language->title }})">{{ old('seo_description_contact.' . $code, $setting->getDirectValue('seo_description_contact', $code)) }}</textarea>
                  <small class="text-muted">Recommended: max 160 characters</small>
                </div>
              </div>
              @endforeach

              <div class="col-md-12"><hr class="my-3"></div>
              {{-- ===== END SEO BLOCK ===== --}}

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Contact us title  ({{ $language->title }})<small>(contact us)</small></label>
                  <textarea name="contact_us_title[{{ $code }}]" rows="2" class="form-control @error('contact_us_title') is-invalid @enderror">{{ old('contact_us_title.' . $code, $setting->getDirectValue('contact_us_title', $code)) }}</textarea>
                  @error('contact_us_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Contact us content  ({{ $language->title }}) <small>(contact us)</small></label>
                  <textarea name="contact_us_content[{{ $code }}]" rows="2" class="form-control @error('contact_us_content') is-invalid @enderror">{{ old('contact_us_content.' . $code, $setting->getDirectValue('contact_us_content', $code)) }}</textarea>
                  @error('contact_us_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                  <label>Contact us cover image <small>(contact us)</small></label>
                  <input type="file" name="contact_us_cover_image" class="form-control @error('contact_us_cover_image') is-invalid @enderror">
                  @error('contact_us_cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  @if($setting->contact_us_cover_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/contact_us_cover_image/'.$setting->contact_us_cover_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Google Map <small>(contact us)</small></label>
                  <textarea name="google_map" rows="2" class="form-control @error('google_map') is-invalid @enderror">{{ old('google_map', $setting->google_map) }}</textarea>
                  @error('google_map') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Our offices in the USA <small>(contact us)</small></label>
                  <textarea name="office_usa" rows="2" class="form-control @error('office_usa') is-invalid @enderror">{{ old('office_usa', $setting->office_usa) }}</textarea>
                  @error('office_usa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Our Offices in Venezuela <small>(contact us)</small></label>
                  <textarea name="office_venezuela" rows="2" class="form-control @error('office_venezuela') is-invalid @enderror">{{ old('office_venezuela', $setting->office_venezuela) }}</textarea>
                  @error('office_venezuela') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

            </div>
          </div>

          
          <div class="tab-pane fade" id="donor_advised" role="tabpanel" aria-labelledby="tab-contact">
            <div class="row">
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_advides_title">Title  ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                  <input type="text" name="donor_advides_title[{{ $code }}]" class="form-control @error('donor_advides_title') is-invalid @enderror" value="{{ old('donor_advides_title.' . $code, $setting->getDirectValue('donor_advides_title', $code)) }}">
                  @error('donor_advides_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_advides_subtitle">Sub Title  ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                  <input type="text" name="donor_advides_subtitle[{{ $code }}]" class="form-control @error('donor_advides_subtitle') is-invalid @enderror" value="{{ old('donor_advides_subtitle.' . $code, $setting->getDirectValue('donor_advides_subtitle', $code)) }}">
                  @error('donor_advides_subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_advides_content">Content  ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                 <textarea name="donor_advides_content[{{ $code }}]" rows="2" class="summernote form-control @error('donor_advides_content') is-invalid @enderror">{{ old('donor_advides_content.' . $code, $setting->getDirectValue('donor_advides_content', $code)) }}</textarea>
                  @error('donor_advides_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach


               <div class="col-md-12">
                <div class="form-group">
                   <label>Image <small>(Donor Advised Funds)</small></label>
                  <input type="file" name="donor_advides_image" class="form-control @error('donor_advides_image') is-invalid @enderror">
                  @error('donor_advides_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  @if($setting->donor_advides_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/donor_advides_image/'.$setting->donor_advides_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>


          <div class="tab-pane fade" id="donor_in_cripto" role="tabpanel" aria-labelledby="tab-contact">
            <div class="row">
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_title_1">First Title ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                  <input type="text" name="donor_cripto_title_1[{{ $code }}]" class="form-control @error('donor_cripto_title_1') is-invalid @enderror" value="{{ old('donor_cripto_title_1.' . $code, $setting->getDirectValue('donor_cripto_title_1', $code)) }}">
                  @error('donor_cripto_title_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_content_1">Content  ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                 <textarea name="donor_cripto_content_1[{{ $code }}]" rows="2" class="summernote form-control @error('donor_cripto_content_1') is-invalid @enderror">{{ old('donor_cripto_content_1.' . $code, $setting->getDirectValue('donor_cripto_content_1', $code)) }}</textarea>
                  @error('donor_cripto_content_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_title_2">Second Title  ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                  <input type="text" name="donor_cripto_title_2[{{ $code }}]" class="form-control @error('donor_cripto_title_2') is-invalid @enderror" value="{{ old('donor_cripto_title_2.' . $code, $setting->getDirectValue('donor_cripto_title_2', $code)) }}">
                  @error('donor_cripto_title_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_content_2">Content ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                 <textarea name="donor_cripto_content_2[{{ $code }}]" rows="2" class="summernote form-control @error('donor_cripto_content_2') is-invalid @enderror">{{ old('donor_cripto_content_2.' . $code, $setting->getDirectValue('donor_cripto_content_2', $code)) }}</textarea>
                  @error('donor_cripto_content_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="how_to_donate_cripto">Donate box cripto ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                 <textarea name="how_to_donate_cripto[{{ $code }}]" rows="2" class="form-control @error('how_to_donate_cripto') is-invalid @enderror">{{ old('how_to_donate_cripto.' . $code, $setting->getDirectValue('how_to_donate_cripto', $code)) }}</textarea>
                  @error('how_to_donate_cripto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach
            </div>
          </div>

















          <div class="tab-pane fade" id="employee_matching_page" role="tabpanel" aria-labelledby="tab-contact">
            <div class="row">
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
               @if ($language->language_code === $locale)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_title_1">Section one ({{ $language->title }})<small>(Employee matching page)</small></label>
                  <textarea name="emp_match_section_1[{{ $code }}]" rows="2" class="summernote form-control @error('emp_match_section_1') is-invalid @enderror">{{ old('emp_match_section_1.' . $code, $setting->getDirectValue('emp_match_section_1', $code)) }}</textarea>
                  @error('emp_match_section_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endif 
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
               @if ($language->language_code === $locale)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_content_1">Section two  ({{ $language->title }})<small>(Employee matching page)</small></label>
                 <textarea name="emp_match_section_2[{{ $code }}]" rows="2" class="summernote form-control @error('emp_match_section_2') is-invalid @enderror">{{ old('emp_match_section_2.' . $code, $setting->getDirectValue('emp_match_section_2', $code)) }}</textarea>
                  @error('emp_match_section_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endif 
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
               @if ($language->language_code === $locale)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donor_cripto_title_2">Section three  ({{ $language->title }})<small>(Employee matching page)</small></label>
                  <textarea name="emp_match_section_3[{{ $code }}]" rows="2" class="summernote form-control @error('emp_match_section_3') is-invalid @enderror">{{ old('emp_match_section_3.' . $code, $setting->getDirectValue('emp_match_section_3', $code)) }}</textarea>
                  @error('emp_match_section_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endif 
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)

               @if ($language->language_code === $locale)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="emp_match_section_4">Section four ({{ $language->title }})<small>(Employee matching page)</small></label>
                 <textarea name="emp_match_section_4[{{ $code }}]" rows="2" class="summernote form-control @error('emp_match_section_4') is-invalid @enderror">{{ old('emp_match_section_4.' . $code, $setting->getDirectValue('emp_match_section_4', $code)) }}</textarea>
                  @error('emp_match_section_4') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endif 
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
               @if ($language->language_code === $locale)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="emp_match_section_5">Section five ({{ $language->title }})<small>(Employee matching page)</small></label>
                 <textarea name="emp_match_section_5[{{ $code }}]" rows="2" class="summernote form-control @error('emp_match_section_5') is-invalid @enderror">{{ old('emp_match_section_5.' . $code, $setting->getDirectValue('emp_match_section_5', $code)) }}</textarea>
                  @error('emp_match_section_5') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endif 
              @endforeach
            </div>
          </div>


          
          <div class="tab-pane fade" id="donate" role="tabpanel" aria-labelledby="tab-contact">
            <div class="row">
              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donate_title">Title  ({{ $language->title }})<small>(Donate)</small></label>
                  <input type="text" name="donate_title[{{ $code }}]" class="form-control @error('donate_title') is-invalid @enderror" value="{{ old('donate_title.' . $code, $setting->getDirectValue('donate_title', $code)) }}">
                  @error('donate_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
               @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donate_subtitle">Donate Subtitle ({{ $language->title }})<small>(Donate)</small></label>
                 <textarea name="donate_subtitle[{{ $code }}]" rows="2" class="form-control @error('donate_subtitle') is-invalid @enderror">{{ old('donate_subtitle.' . $code, $setting->getDirectValue('donate_subtitle', $code)) }}</textarea>
                  @error('donate_subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
               @endforeach


              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
               <div class="col-md-12">
                <div class="form-group">
                  <label for="donate_description">Description ({{ $language->title }})<small>(Donate)</small></label>
                 <textarea name="donate_description[{{ $code }}]" rows="2" class="form-control @error('donate_description') is-invalid @enderror">{{ old('donate_description.' . $code, $setting->getDirectValue('donate_description', $code)) }}</textarea>
                  @error('donate_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                   <label>Donate Hero Image <small>(Donate)</small></label>
                  <input type="file" name="donate_hero_image" class="form-control @error('donate_hero_image') is-invalid @enderror">
                  @error('donate_hero_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  @if($setting->donate_hero_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/donate_hero_image/'.$setting->donate_hero_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label for="global_donorbox_code">Global Donate box ({{ $language->title }})<small>(Donor Advised Funds)</small></label>
                 <textarea name="global_donorbox_code[{{ $code }}]" rows="2" class="form-control @error('global_donorbox_code') is-invalid @enderror">{{ old('global_donorbox_code.' . $code, $setting->getDirectValue('global_donorbox_code', $code)) }}</textarea>
                  @error('global_donorbox_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
               @endforeach

               <div class="col-md-12">
                <div class="form-group">
                  <label>Tagline</label>
                  <input type="text" name="tag_line" class="form-control" value="{{ $setting->tag_line }}">
                </div>
              </div>
            </div>
          </div>

        </div> {{-- tab-content end --}}
      </div>

      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Update Settings
        </button>
      </div>
    </form>


  </div>
</div>




@endsection


@section('js')
<script>
  $(function () {
    // If any invalid field exists, open its tab automatically
    let $firstInvalid = $('.is-invalid').first();
    if ($firstInvalid.length) {
      let $pane = $firstInvalid.closest('.tab-pane');
      if ($pane.length) {
        $('a[data-toggle="pill"][href="#' + $pane.attr('id') + '"]').tab('show');
      }
    }
  });
</script>





@endsection 
