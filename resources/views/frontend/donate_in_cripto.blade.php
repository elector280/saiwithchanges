@extends('frontend.layouts.master')

@section('title', translate('How to donate in cryptocurrency page meta title'))
@section('meta_description', translate('How to donate in cryptocurrency page meta description'))
@section('meta_keyword', translate('How to donate in cryptocurrency page meta keyword'))

@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ translate('How to donate in cryptocurrency page title') }}">
  <meta property="og:description" content="{{ translate('How to donate in cryptocurrency page description') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/logo/'.$setting->logo) }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="{{ asset('storage/logo/'.$setting->logo) }}">
  <meta name="twitter:title" content="{{ translate('How to donate in cryptocurrency page title') }}">
  <meta name="twitter:description" content="{{ translate('How to donate in cryptocurrency page description') }}"> 
  <meta name="twitter:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
@endsection


@section('frontend')

<!-- ================= HOW TO DONATE CRYPTOCURRENCY (CLONED DESIGN) ================= -->
<section class="bg-[#f5f5f5] pt-40 md:pt-48 pb-8 -mt-40 md:-mt-36">

    <div class="max-w-6xl md:mx-auto md:px-4 space-y-10 main-div">

        <!-- ========== TOP: HOW TO DONATE + SIDE CARD ========== -->
        <div class="bg-white- shadow-md- border border-gray-200-">

            <!-- red/orange gradient title bar -->
            <div class="bg-gradient-to-r from-[#ff5b5b] via-[#ff6d4c] to-[#ffb147] px-8 py-6 h-[120px] flex items-center">
                <h1 class="text-[34px] md:text-[40px] font-semibold text-white uppercase leading-[1.05] tracking-[0.02em]">
                    @if(!empty($setting->donor_cripto_title_1))
                        {!! $setting->donor_cripto_title_1 !!}
                    @endif
                </h1>
            </div>

            <div class="px-8 py-8">
                <a href="#" id="mobileDonateBtn" class="md:hidden w-full block text-center  py-2 border border-[#f3b6b6] bg-[#fff1f1] text-[#D94647]
                    font-semibold uppercase  rounded-[2px]">
                     {{ translate('DONATE CRYPTO') }}
            </a>
            </div>



            <!-- content + sidebar -->
            <div class="px-8 md:py-10">
                <div class="grid lg:grid-cols-[2.2fr,1fr] gap-8 items-start">

                    <!-- LEFT TEXT -->
                    <div class="space-y-6 text-[15px] leading-relaxed text-gray-700">

                    @if(!empty($setting->donor_cripto_content_1))
                        {!! $setting->donor_cripto_content_1 !!}
                    @endif

                    </div>

                    <!-- RIGHT SIDE: DONATION BOX -->
                    {{-- ✅ The Giving Block widget inside your ASIDE box (Choose Method) --}}
                    <aside class="hidden sm:block bg-white shadow-lg border border-gray-200 rounded-sm overflow-hidden text-xs text-gray-700">
                        <!-- widget -->
                        <div class="bg-white">
                            <div class="rounded-sm border border-gray-200 overflow-hidden bg-white">
                                @if(!empty($setting->how_to_donate_cripto))
                                    {!! $setting->how_to_donate_cripto !!}
                                @endif
                            </div>
                        </div>
                    </aside>

                    <style>
                    /* ✅ make iframe fit inside aside */
                    .tgb-iframe{
                        width: 100% !important;
                        max-width: 100% !important;
                        border: 0 !important;
                        display: block !important;

                        /* ✅ your iframe says height 600, keep same or increase if needed */
                        height: 600px !important;
                    }
                    </style>


                </div>
            </div>
        </div>

        <!-- ========== MIDDLE: CONTACT FOR MORE INFOS ========== -->
        <div class="bg-white- shadow-md- border- border-gray-200- px-8 md:py-10">
            <div class="grid md:grid-cols-[1.2fr,2fr] gap-8">

                <div>
                    <h2 class="text-2xl font-bold text-[#f04848] uppercase mb-2">
                       @if(!empty($setting->donor_cripto_title_2))
                        {!! $setting->donor_cripto_title_2 !!}
                        @endif
                    </h2>
                </div>

                <div class="space-y-4 text-[15px] leading-relaxed text-gray-700">
                    @if(!empty($setting->donor_cripto_content_2))
                        {!! $setting->donor_cripto_content_2 !!}
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="hidden max-w-6xl md:mx-auto md:px-4 space-y-10 mobile-show-div hidden">
        <div class="bg-white shadow-md border border-gray-200">
            <div class="bg-white">
                <div class="rounded-sm border border-gray-200 overflow-hidden bg-white">
                    @if(!empty($setting->how_to_donate_cripto))
                        {!! $setting->how_to_donate_cripto !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


@include('frontend.includes.news_letter')

 <div class="py-5 bg-[#f6f6f6]"> 
      @include('frontend.includes.scroll_element')
  </div>



<script>
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('mobileDonateBtn');
  const mainDiv = document.querySelector('.main-div');
  const mobileShowDiv = document.querySelector('.mobile-show-div');

  if (!btn || !mainDiv || !mobileShowDiv) return;

  btn.addEventListener('click', (e) => {
    e.preventDefault();

    // hide main
    mainDiv.classList.add('hidden');

    // show mobile div
    mobileShowDiv.classList.remove('hidden');

    // optional: smooth scroll to the shown div
    mobileShowDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
});
</script>


@endsection