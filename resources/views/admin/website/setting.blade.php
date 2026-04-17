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
            <a class="nav-link" id="tab-home" data-toggle="pill" href="#pane-home" role="tab" aria-controls="pane-home" aria-selected="false">
              <i class="fas fa-home mr-1"></i> Home
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

          {{-- ================= HOME ================= --}}
          <div class="tab-pane fade" id="pane-home" role="tabpanel" aria-labelledby="tab-home">
            <div class="row">

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>About us title  ({{ $language->title }}) <small>(Home)</small></label>
                  <input type="text" name="about_us_title_home[{{ $code }}]" value="{{ old('about_us_title_home.' . $code, $setting->getDirectValue('about_us_title_home', $code)) }}" class="form-control" placeholder="Enter About us title for home  ({{ $language->title }})">
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                  <label>About us button link <small>(Home)</small></label>
                  <input type="text" name="about_us_btn_home" value="{{ old('about_us_btn_home', $setting->about_us_btn_home) }}" class="form-control" placeholder="Enter About us button link for home">
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>About us content  ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="about_us_content_home[{{ $code }}]" rows="2" class="form-control @error('about_us_content_home') is-invalid @enderror" placeholder="Enter About us content for home  ({{ $language->title }})">{{ old('about_us_content_home.' . $code, $setting->getDirectValue('about_us_content_home', $code)) }}</textarea>
                  @error('about_us_content_home') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="form-group">
                  <label>About us cover image for home <small>(Home)</small></label>
                  <input type="file" name="about_us_cover_image_home" class="form-control @error('about_us_cover_image_home') is-invalid @enderror">
                  @error('about_us_cover_image_home') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  @if($setting->about_us_cover_image_home)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/about_us_cover_image_home/'.$setting->about_us_cover_image_home) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>










              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Article & news content  ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="article_news_content[{{ $code }}]" rows="2" class="form-control @error('article_news_content') is-invalid @enderror">{{ old('article_news_content.' . $code, $setting->getDirectValue('article_news_content', $code)) }}</textarea>
                  @error('article_news_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Review title  ({{ $language->title }})<small>(Home)</small></label>
                  <input type="text" name="review_title[{{ $code }}]" value="{{ old('review_title.' . $code, $setting->getDirectValue('review_title', $code)) }}" class="form-control" placeholder="Enter Review title for home  ({{ $language->title }})">
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Review sub title  ({{ $language->title }}) <small>(Home)</small></label>
                  <input type="text" name="review_sub_title[{{ $code }}]" value="{{ old('review_sub_title.' . $code, $setting->getDirectValue('review_sub_title', $code)) }}" class="form-control" placeholder="Enter Review sub title for home  ({{ $language->title }})">
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Review content  ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="review_content[{{ $code }}]" rows="2" class="form-control @error('review_content') is-invalid @enderror">{{ old('review_content.' . $code, $setting->getDirectValue('review_content', $code)) }}</textarea>
                  @error('review_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Our numbers ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="our_numbers_content[{{ $code }}]" rows="2" class="form-control @error('our_numbers_content') is-invalid @enderror">{{ old('our_numbers_content.' . $code, $setting->getDirectValue('our_numbers_content', $code)) }}</textarea>
                  @error('our_numbers_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>People Helped <small>(Home)</small></label>
                  <input type="text" name="peaple_helped" class="form-control @error('peaple_helped') is-invalid @enderror" value="{{ old('peaple_helped', $setting->peaple_helped) }}">
                </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Volunteers <small>(Home)</small></label>
                  <input type="text" name="volunteers" class="form-control @error('volunteers') is-invalid @enderror" value="{{ old('volunteers', $setting->volunteers) }}">
                </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Educated children <small>(Home)</small></label>
                  <input type="text" name="educated_children" class="form-control @error('educated_children') is-invalid @enderror" value="{{ old('educated_children', $setting->educated_children) }}">
                </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                  <label>Served Meal <small>(Home)</small></label>
                  <input type="text" name="service_meal" class="form-control @error('service_meal') is-invalid @enderror" value="{{ old('service_meal', $setting->service_meal) }}">
                </div>
                  </div>
                </div>
              </div>




              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Help People in Need content ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="help_people_need_content[{{ $code }}]" rows="2" class="form-control @error('help_people_need_content') is-invalid @enderror">{{ old('help_people_need_content.' . $code, $setting->getDirectValue('help_people_need_content', $code)) }}</textarea>
                  @error('help_people_need_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              
              <div class="col-md-12">
                <div class="form-group">
                  <label>Help People in Need button <small>(Home)</small></label>
                  <input type="text" name="help_people_need_btn" class="form-control @error('help_people_need_btn') is-invalid @enderror" placeholder="https://www.example.com" value="{{ old('help_people_need_btn', $setting->help_people_need_btn) }}">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Help People in Need cover image <small>(Home)</small></label>
                  <input type="file" name="help_people_need_image" class="form-control @error('help_people_need_image') is-invalid @enderror">
                  @error('help_people_need_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  @if($setting->help_people_need_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/help_people_need_image/'.$setting->help_people_need_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Start Volunteering content ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="start_volunteering_content[{{ $code }}]" rows="2" class="form-control @error('start_volunteering_content') is-invalid @enderror">{{ old('start_volunteering_content.' . $code, $setting->getDirectValue('start_volunteering_content', $code)) }}</textarea>
                  @error('start_volunteering_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Become Sponsor content ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="become_sponsor_content[{{ $code }}]" rows="2" class="form-control @error('become_sponsor_content') is-invalid @enderror">{{ old('become_sponsor_content.' . $code, $setting->getDirectValue('become_sponsor_content', $code)) }}</textarea>
                  @error('become_sponsor_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Help More content ({{ $language->title }}) <small>(About)</small></label>
                  <textarea name="help_more_content[{{ $code }}]" rows="2" class="form-control @error('help_more_content') is-invalid @enderror">{{ old('help_more_content.' . $code, $setting->getDirectValue('help_more_content', $code)) }}</textarea>
                  @error('help_more_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              @foreach (App\Models\Language::where('active', 1)->get() as $language)
                @php $code = $language->language_code; @endphp
              <div class="col-md-12">
                <div class="form-group">
                  <label>Download Annual Report ({{ $language->title }}) <small>(Home)</small></label>
                  <textarea name="download_annual_report_content[{{ $code }}]" rows="2" class="form-control @error('download_annual_report_content') is-invalid @enderror">{{ old('download_annual_report_content.' . $code, $setting->getDirectValue('download_annual_report_content', $code)) }}</textarea>
                  @error('download_annual_report_content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              @endforeach

              <div class="col-md-12">
                  <div class="form-group">
                      <label>
                          Download Annual Report file <small>(Home)</small>
                      </label>

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
                  <label>Contact us button <small>(Home)</small></label>
                  <input type="text" name="contact_us_button_volun" class="form-control @error('contact_us_button_volun') is-invalid @enderror" placeholder="https://www.example.com" value="{{ old('contact_us_button_volun', $setting->contact_us_button_volun) }}">
                </div>
              </div>

              {{-- campaign footer cover image --}}
              <div class="col-md-12">
                <div class="form-group">
                  <label>Campaign footer cover image <small>(campaign details)</small></label>
                  <input type="file" name="campaign_cover_image" class="form-control @error('campaign_cover_image') is-invalid @enderror">
                  @error('campaign_cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  @if($setting->campaign_cover_image)
                    <div class="img-preview-box mt-2">
                      <img src="{{ asset('storage/campaign_cover_image/'.$setting->campaign_cover_image) }}" class="img-thumbnail">
                    </div>
                  @endif
                </div>
              </div>

            </div>
          </div>

          {{-- ================= ABOUT ================= --}}
          <div class="tab-pane fade" id="pane-about" role="tabpanel" aria-labelledby="tab-about">
            <div class="row">

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



@include('admin.summernote_modal')
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


<script src="{{ asset('backend-asset') }}/summernote-custom-input.js"></script>


@endsection 
