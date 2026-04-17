@extends('frontend.layouts.master')

@section('title', translate('About us page meta title'))
@section('meta_description', translate('About us page meta description'))
@section('meta_keyword', translate('About us page meta keyword'))

@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ translate('About us page title') }}">
  <meta property="og:description" content="{{ translate('About us page description') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="{{ translate('About us page image') }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="{{ asset('storage/logo/'.$setting->logo) }}">
  <meta name="twitter:title" content="{{ translate('About us page title') }}">
  <meta name="twitter:description" content="{{ translate('About us page description') }}"> 
  <meta name="twitter:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
@endsection


@section('frontend')

<section class="-mt-36">
  <div class="relative w-full h-[620px] bg-center bg-cover"
       style="background-image:url('{{ asset('storage/about_us_cover_image/'.$setting->about_us_cover_image) }}'); ">

    <!-- overlay --> 
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-black/10"></div>

    <!-- ✅ same container as header -->
    <div class="relative z-10 h-full max-w-6xl px-6 mx-auto lg:px-10">
      <!-- ✅ logo বরাবর আনতে: left aligned + middle/bottom position control -->
      <div class="flex items-center h-full">
        <div class="max-w-xl text-white">
          <p class="uppercase mb-2 text-[#FFF0A1] text-sm tracking-widest">
              {{ translate('About us') }}
          </p> 

          <h1 class="text-2xl font-semibold leading-snug md:text-3xl whitespace-pre-line">
            @if(!empty($setting->about_us_title))
                {!! $setting->about_us_title !!}
              @endif
          </h1>
        </div>
      </div>
    </div>

  </div>
</section>


<section class="bg-[#F96465]">
    {{-- MOBILE: map background + text overlay --}}
    <div class="relative block md:hidden h-[500px] text-white"
         style="background-image: url('{{ asset('images/map.png') }}');
                background-size: cover;
                background-position: center;">
        {{-- optional overlay for better contrast --}}
        <div class="absolute inset-0 bg-[#f96465]/50"></div>

       <div class="relative flex flex-col items-center justify-between h-full px-4 py-8 text-center">
          <!-- top block -->
          <div>
              <h2 class="text-3xl font-semibold uppercase text-[#ffe68a]">
                   {{ translate('Our Mission') }}
              </h2>

              <p class="mb-3 uppercase text-md">
                   {{ translate('Urgent Fundraisings') }}
              </p>

              <button
                  class="inline-flex items-center gap-2 py-5 mb-6 text-xs font-semibold uppercase">
                  <span> {{ translate('Explore more') }}</span>
                  <i class="fa-solid fa-chevron-down"></i>
              </button>
          </div>

          <!-- bottom text -->
          <p class="max-w-xs mb-4 text-xl leading-relaxed text-left  whitespace-pre-line">
              @if(!empty($setting->our_mission))
                {!! $setting->our_mission !!}
              @endif
          </p>

      </div>


    </div>

    {{-- DESKTOP/TABLET: left map, right content --}}
    <div class="hidden md:block">
        <div class="relative" style="height: 400px;">
            <div class="grid h-full text-white md:grid-cols-2">
                {{-- image left --}}
                <div class="flex">
                    <img src="{{ asset('images/map.png') }}"
                         alt="{{ translate('South America map alt') }}" alt="{{ translate('South America map title') }}"
                         class="object-contain w-full h-full opacity-90">
                </div>

                {{-- text right --}}
                <div class="px-6 py-16">
                    <h2 class="text-xl md:text-2xl font-bold uppercase mb-3 text-[#ffe68a]">
                         {{ translate('Our Mission') }}
                    </h2>

                    <p class="mb-8 text-base leading-relaxed md:text-lg text-white/90  whitespace-pre-line">
                        @if(!empty($setting->our_mission))
                          {!! $setting->our_mission !!}
                        @endif
                    </p>

                    <button
                        class="inline-flex items-center gap-2 text-xs md:text-sm font-semibold uppercase tracking-[0.18em]">
                        <span> {{ translate('Explore more') }}</span>
                        <span class="text-lg leading-none">⌄</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="bg-white">
    <div class="max-w-6xl px-4 md:px-4 lg:px-0 py-16 mx-auto md:py-20">
        <div class="grid items-center gap-10 md:grid-cols-2">
            <div class="relative">
                <div class="relative z-10">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#585858] mb-4 leading-snug">
                        {!! translate('Malnutrition #1 Cause') !!}
                    </h2>

                    <p class="text-[15px] leading-relaxed text-gray-600 mb-8  whitespace-pre-line">
                        @if(!empty($setting->donate_orphans_content))
                          {!! $setting->donate_orphans_content !!}
                        @endif
                    </p>

                  <a href="{{ $setting->donate_to_feeding_dream }}" class="block w-full md:inline-block md:w-auto
                        bg-[#f04848] hover:bg-[#e33838] text-white
                        text-xs md:text-sm font-semibold uppercase
                        px-8 md:px-10 py-1 rounded-md text-center
                        shadow-[0_12px_25px_rgba(240,72,72,0.45)]
                        flex items-center justify-center gap-2"  style="border: 1px solid red !important;">
                  
                  {{ translate('DONATE to FEEDING DREAM') }}
                  <i class="text-sm fa-solid fa-chevron-right"></i> 
              </a>

                </div>
            </div>

            <!-- RIGHT: OVERLAPPED IMAGES -->
            <div class="relative h-[320px] sm:h-[360px] md:h-[430px]">
                <!-- BACK IMAGE -->
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[90%] h-[65%] overflow-hidden rounded-md
                          md:left-0 md:translate-x-0 md:w-[70%] md:h-full">
                    <img src="{{ asset('storage/about_us_image_1/'.$setting->about_us_image_1) }}"
                        alt="{{ translate('Animals help alt1') }}"  title="{{ translate('Animals help image title') }}" 
                        class="object-cover w-full h-full">
                </div>

                <!-- FRONT IMAGE -->
                <div
                    class="absolute bottom-2 left-1/2 -translate-x-1/2 w-[80%] h-[55%] flex items-center justify-center
                          sm:bottom-4
                          md:-bottom-16 md:-right-12 md:left-auto md:translate-x-0 md:w-[60%] md:h-full">
                    <div class="w-full h-full overflow-hidden rounded-md">
                        <img src="{{ asset('storage/about_us_image_2/'.$setting->about_us_image_2) }}"
                            alt="{{ translate('Shelter image alt2') }}" title="{{ translate('Shelter image title') }}"
                            class="object-cover w-full h-full">
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- ========== 2. DOG SANCTUARY HERO CARD ========== -->
    <div class="max-w-6xl md:px-4 lg:px-auto md:mx-auto md:py-20">
        <div class="bg-white md:rounded-[10px] overflow-hidden">
            <div class="grid md:grid-cols-2">
                <!-- LEFT: IMAGE -->
                <div class="h-full md:h-full">
                    <img src="{{ asset('storage/urgent_help_image/'.$setting->urgent_help_image) }}"  alt="{{ translate('urgent help alt') }}" title="{{ translate('urgent help image title') }}" class="object-cover w-full h-full">
                </div>

                <!-- RIGHT: CONTENT -->
                <div class="bg-[#f15656] text-white px-10 pt-10 flex flex-col justify-center  py-16">
                    <!-- <span  class="inline-flex items-center mb-4 px-4 py-1
                              rounded-md bg-gradient-to-r from-[#1e73be] to-[#0c4a8e]
                              text-[10px] font-semibold uppercase w-[120px] ">
                         {{ translate('Urgent help') }}
                    </span> -->


                    <h2 class="text-2xl md:text-2xl font-semibold text-[#FAD694] leading-snug mb-4  whitespace-pre-line">
                        @if(!empty($setting->urgent_help_title))
                          {!! $setting->urgent_help_title !!}
                        @endif
                    </h2>

                    <p class="text-[14px] md:text-[15px] leading-relaxed text-[#ffe9e9] mb-8  whitespace-pre-line">
                         @if(!empty($setting->urgent_help_description))
                          {!! $setting->urgent_help_description !!}
                        @endif
                    </p> 

                    <a href="{{ $setting->help_people_need_btn }}"  class="self-start bg-white text-[#f15656] text-xs md:text-sm font-semibold uppercase px-9 py-1 rounded-md shadow-[0_12px_25px_rgba(0,0,0,0.25)]"  style="border: 1px solid red !important;">
                         {{ translate('Donate to Dog Sanctuary') }} &gt;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== 3. SECOND TEXT + OVERLAP IMAGES BLOCK ========== -->
    <div class="max-w-6xl px-4 md:px-4 lg:px-auto py-8 mx-auto md:py-20">
        <div class="grid items-center gap-10 md:grid-cols-2">

            <!-- LEFT: TEXT + CTA -->
            <div>
                <h2 class="mb-4 text-2xl font-bold leading-snug text-gray-900 md:text-3xl">
                     {!! translate('Helping People Animals in<br>') !!}
                </h2>

                <p class="text-[15px] leading-relaxed text-gray-600 mb-8">
                    SAI began operating in Venezuela providing humanitarian aid to hospitalized
                    patients, orphaned children, the homeless, elderly who have been abandoned
                    and forgotten in nursing homes and families who do not have shelter or food
                    to eat.
                </p>

                <a href="{{ $setting->donate_to_orphan_program }}" class="block w-full md:inline-block md:w-auto
                        bg-[#f04848] hover:bg-[#e33838] text-white
                        text-xs md:text-sm font-semibold uppercase
                        px-8 md:px-10 py-1 rounded-md text-center
                        shadow-[0_12px_25px_rgba(240,72,72,0.45)]
                        flex items-center justify-center gap-2"  style="border: 1px solid red !important;">
                  
                  {{ translate('Donate to Orphans Program') }}
                  <i class="text-sm fa-solid fa-chevron-right"></i>
              </a>

            </div>

            <!-- RIGHT: OVERLAPPED IMAGES -->
            <div class="relative h-[320px] sm:h-[360px] md:h-[430px]">
                <!-- BACK IMAGE -->
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[90%] h-[65%] overflow-hidden rounded-md
                          md:left-0 md:translate-x-0 md:w-[70%] md:h-full">
                    <img src="{{ asset('storage/about_us_image_3/'.$setting->about_us_image_3) }}"
                        alt="{{ translate('Animals help alt3') }}" title="{{ translate('Animals help image 3 title') }}"
                        class="object-cover w-full h-full">
                </div>

                <!-- FRONT IMAGE -->
                <div
                    class="absolute bottom-2 left-1/2 -translate-x-1/2 w-[80%] h-[55%] flex items-center justify-center
                          sm:bottom-4
                          md:-bottom-16 md:-right-12 md:left-auto md:translate-x-0 md:w-[60%] md:h-full">
                    <div class="w-full h-full overflow-hidden rounded-md">
                        <img src="{{ asset('storage/about_us_image_4/'.$setting->about_us_image_4) }}"
                            alt="{{ translate('Shelter image alt4') }}" title="{{ translate('Animals help image 4 title') }}"
                            class="object-cover w-full h-full">
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- subtle bottom gradient fade -->
    <!-- <div class="h-20 bg-gradient-to-b from-transparent to-[#ffe6e6]"></div> -->
</section>


    <section class="bg-[#D94647] sm:mt-20">
      <div class="relative max-w-7xl  md:px-4 lg:px-auto mx-auto">
        <div class="mt-5 pt-5 pb-8 bg-[#D94647]">
          <div class="max-w-4xl px-4 mx-auto text-center">
            <h3
              class="text-[18px] lg:text-[22px] font-bold uppercase text-white">
              {{ translate('OUR CERTIFICATIONS') }}
            </h3>

            <div class="mt-3 mx-auto w-24 h-[3px] bg-[#e13b35]/80 rounded-full"></div>

            {{-- প্রতি রোতে ২টা image --}}
            <div class="grid items-center grid-cols-2 gap-6 mt-5 md:grid-cols-4 md:gap-10 justify-items-center">

             @php 
                  $certifications = App\Models\Sponsor::where('type', 'certifications')->latest()->get();
              @endphp
              @foreach($certifications as $item)
              <div>
                <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}"
                  alt="{{ $item->company_name }}"
                  class="h-full sm:h-full md:h-full w-auto object-contain drop-shadow-[0_8px_18px_rgba(0,0,0,0.25)]" />
                </div>
                @endforeach
              
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ========== OUR SPONSORS (AUTO SLIDE) ========== -->
     <br>
    @include('frontend.includes.our_sponsors')
    
    <section class="py-5 bg-[#f8e9e9]">
      <div class="max-w-7xl  md:px-4 lg:px-auto py-12- mx-auto">
          @include('frontend.includes.our_values')
      </div>


    </section>
<!-- ================= OUR NUMBERS (IMAGE CLONE) ================= -->
    <section class="pb-5 bg-[#f8e9e9]">
        <div class="max-w-7xl  md:px-4 lg:px-auto md:mx-auto">
            @include('frontend.includes.our_number_section')
        </div>
    </section>
    <!-- ================= CTA + 3 CARDS (IMAGE CLONE) ================= -->
    <section class="py-20 lg:py-20 bg-[#D94647]">
      <div class="max-w-7xl  md:px-4 lg:px-auto mx-auto">

        <div class="flex flex-col overflow-hidden text-white bg-white/10 backdrop-blur-sm rounded-xl md:flex-row">

          <!-- LEFT CONTENT -->
          <div class="flex flex-col items-start justify-between flex-1 gap-6 px-8 py-10 lg:py-14 lg:flex-row lg:items-center">

            <!-- TITLE -->
            <div>
              <h2 class="text-3xl leading-tight tracking-tight text-yellow-200 lg:text-4xl font-semibold-">
                 {!! translate('OUR ANNUAL REPORT') !!}
              </h2>
            </div>

            <!-- DESCRIPTION -->
            <div class="max-w-md text-base leading-relaxed text-white/90">
              <p>
                @if(!empty($setting->annual_report_content))
                  {!! $setting->annual_report_content !!}
                @endif
              </p>
                @if(!empty($setting->download_annual_report_file))
                    <a href="{{ asset('storage/download_annual_report_file/'.$setting->download_annual_report_file) }}"
                      download
                      class="mt-6 inline-flex items-center justify-center  w-[220px]
                              bg-white text-[#ff6b6b] text-[12px] font-semibold uppercase px-10 py-1
                              shadow-[0_10px_25px_rgba(0,0,0,0.18)]  hover:shadow-[0_12px_28px_rgba(0,0,0,0.22)]
                              transition"  style="border: 1px solid red !important;">
                          {{ translate('DOWNLOAD REPORT') }} <span class="ml-2">&gt;</span>
                    </a>
                @else
                    <button type="button"
                        class="mt-6 inline-flex items-center justify-center w-[220px]
                              bg-white text-[#ff6b6b] text-[12px] font-semibold uppercase  px-10 py-3
                              shadow-[0_10px_25px_rgba(0,0,0,0.10)]  opacity-60 cursor-not-allowed"  style="border: 1px solid red !important;">
                          {{ translate('FILE NOT AVAILABLE') }} <span class="ml-2">&gt;</span>
                    </button>
                @endif


            </div>

          </div>

          <!-- RIGHT IMAGE -->
          <div class="relative flex-1 min-h-[240px]">
            <img
              src="{{ asset('storage/anual_report_cover_img/'.$setting->anual_report_cover_img) }}"
              alt="{{ translate('Annual report cover image alt') }}" title="{{ translate('Annual report cover image title') }}"
              class="object-cover w-full h-full rounded-md"
            />
          </div>

        </div>

      </div>
    </section>


    <section>
  <div class="max-w-7xl  md:px-4 lg:px-auto mx-auto py-20">
    <div class="grid gap-10 text-sm md:grid-cols-3 text-slate-800">

      <!-- CARD 1 -->
      <article class="flex flex-col h-full">
        <hr class="mb-3">
        <h3 class="text-[26px] font-bold tracking-[0.04em] text-[#e13b35] uppercase">
          {{ translate('Start Volunteering') }}
        </h3>

        <!-- ✅ content grows, keeps equal height -->
        <p class="mt-3 text-[16px] leading-relaxed text-slate-600 whitespace-pre-line flex-1">
          @if(!empty($setting->start_volunteering_content))
            {!! $setting->start_volunteering_content !!}
          @endif
        </p>

        <!-- ✅ button stays at bottom -->
        <a href="{{ $setting->contact_us_button_volun }}"
           class="mt-6 inline-flex w-fit items-center justify-center border border-[#e13b35]
                  text-[#e13b35] text-[11px] uppercase px-6 py-2"  style="border: 1px solid red !important;">
          {{ translate('Contact Us') }} &gt;
        </a>
      </article>

      <!-- CARD 2 -->
      <article class="flex flex-col h-full">
        <hr class="mb-3">
        <h3 class="text-[26px] font-bold tracking-[0.04em] text-[#e13b35] uppercase">
          {{ translate('Become Sponsor') }}
        </h3>

        <p class="mt-3 text-[16px] leading-relaxed text-slate-600 whitespace-pre-line flex-1">
          @if(!empty($setting->become_sponsor_content))
            {!! $setting->become_sponsor_content !!}
          @endif
        </p>

        <a href="{{ $setting->contact_us_button_volun }}"
           class="mt-6 inline-flex w-fit items-center justify-center border border-[#e13b35]
                  text-[#e13b35] text-[11px] uppercase px-6 py-2"  style="border: 1px solid red !important;">
          {{ translate('Contact Us') }} &gt;
        </a>
      </article>

      <!-- CARD 3 -->
      <article class="flex flex-col h-full">
        <hr class="mb-3">
        <h3 class="text-[26px] font-bold tracking-[0.04em] text-[#e13b35] uppercase">
          {{ translate('Help More') }}
        </h3>

        <p class="mt-3 text-[16px] leading-relaxed text-slate-600 whitespace-pre-line flex-1">
          @if(!empty($setting->our_numbers_content))
            {!! $setting->our_numbers_content !!}
          @endif
        </p>

        <a href="{{ $setting->contact_us_button_volun }}"
           class="mt-6 inline-flex w-fit items-center justify-center border border-[#e13b35]
                  text-[#e13b35] text-[11px] uppercase px-6 py-2"  style="border: 1px solid red !important;">
          {{ translate('Contact Us') }} &gt;
        </a>
      </article>

    </div>
  </div>
</section>


  @include('frontend.includes.news_letter')

  <div class="py-5 bg-[#f6f6f6]"> 
      @include('frontend.includes.scroll_element')
  </div>

@endsection
