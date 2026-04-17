@extends('frontend.layouts.master')

@section('title', translate('DONOR ADVISED FUNDS page meta title'))
@section('meta_description', translate('Donor Advised Funds page meta description'))
@section('meta_keyword', translate('Donor Advised Funds page meta keyword'))

@section('meta')
  <link rel="canonical" href="{{ url()->current() }}">

  {{-- Open Graph --}}
  <meta property="og:title" content="{{ translate('Donor Advised Funds page title') }}">
  <meta property="og:description" content="{{ translate('Donor Advised Funds page description') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('storage/logo/'.$setting->logo) }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="{{ asset('storage/logo/'.$setting->logo) }}">
  <meta name="twitter:title" content="{{ translate('Donor Advised Funds page title') }}">
  <meta name="twitter:description" content="{{ translate('Donor Advised Funds page description') }}"> 
  <meta name="twitter:image" content="{{ asset('storage/logo/'.$setting->logo) }}">
@endsection



@section('frontend')

<style>
    /* ✅ Fit widget inside aside */
    #dafdirectdiv{
        background:#fff !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow: hidden !important;
    }
    #dafdirectdiv img{ max-width:100% !important; height:auto !important; }
    #dafdirectdiv input, #dafdirectdiv select{
        width:100% !important; max-width:100% !important; box-sizing:border-box !important;
    }
    #amountNextContain{
        display:flex !important;
        gap:8px !important;
        align-items:flex-end !important;
    }
    .dafdirectInputAmount{ flex:1 1 auto !important; }
    .dafdirectButtonContain{ flex:0 0 auto !important; }
    .dafdirectButtonContain img{ width:92px !important; height:auto !important; }
</style>

<!-- ============== DONOR ADVISED FUNDS SECTION (IMAGE CLONE) ============== -->
<section class="bg-[#f5f5f5] pt-40 md:pt-48 pb-8 -mt-40 md:-mt-36">
    <div class="max-w-6xl md:mx-auto md:px-4 space-y-10">

        <!-- ================== TOP GRADIENT STRIP ================== -->
        <!-- TOP STRIP : LEFT TEXT + RIGHT IMAGE -->
        <div class="shadow-md-">
            <div class="grid md:grid-cols-[3fr,1.2fr]">
                <div class="relative flex items-center px-8 py-6 h-[250px] md:h-auto
                            bg-[radial-gradient(140%_120%_at_0%_100%,#5B4A86_0%,rgba(91,74,134,0.65)_18%,rgba(91,74,134,0)_52%),linear-gradient(90deg,#FF5B5B_0%,#FF6D4C_45%,#FFB147_100%)]
                            bg-no-repeat bg-[length:100%_100%]" >
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold tracking-[0.03em] uppercase text-[#ffeab8]">
                        {{ $setting->donor_advides_title }}
                        </h1>
                        <p class="text-lg md:text-xl font-semibold tracking-[0.03em] uppercase text-white">
                        {{ $setting->donor_advides_subtitle }}
                        </p>
                    </div>
                </div>

                <!-- RIGHT : WHITE AREA WITH IMAGE -->
                <div class="hidden sm:block bg-white flex items-center justify-center px-6- py-4-">
                    <img src="{{ asset('storage/donor_advides_image/'.$setting->donor_advides_image) }}" 
                        alt="{{ translate('DAF Direct') }}" title="{{ translate('DAF Direct') }}"
                        class="max-h-full w-auto object-contain">
                </div>
            </div>
        </div>

        <a href="#" class="md:hidden w-full block text-center  py-2 border border-[#f3b6b6] bg-[#fff1f1] text-[#D94647]
                font-semibold uppercase  rounded-[2px]">
                 {{ translate('Donate through DAF') }}
        </a>


        <!-- ================== MIDDLE CONTENT + DONATION CARD ================== -->
        <div class="grid lg:grid-cols-[2.5fr,1fr] gap-8 items-start">

            <!-- LEFT WHITE CONTENT CARD -->
            <article class="bg-white border border-gray-200 shadow-md px-8 py-8 text-[15px] leading-relaxed text-gray-700">
                @if(!empty($setting->donor_advides_content))
                    <section class="space-y-2 prose max-w-none">
                        {!! $setting->donor_advides_content !!}
                    </section>
                @endif
            </article>

            <!-- RIGHT DONATION SIDEBAR CARD -->
            <!-- ================= DONATE CARD WITH WORKING TABS ================= -->
            <div id="donateBox"  class="hidden sm:block bg-white border border-gray-200  text-xs text-gray-700 w-full md:mx-auto overflow-hidden">

                <!-- blue header -->
                <div class="bg-[#185a9d] text-white px-4 py-2 rounded-t-sm flex items-center justify-between">
                    <span class="text-[11px] font-bold uppercase tracking-[0.03em]">Choose amount</span>
                    <div class="flex gap-1 text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-white/80"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-white/30"></span>
                    </div>
                </div>

                <!-- body -->
                <div class="p-4 space-y-4">

                    <div class="text-center">
                        <p class="text-[13px] font-extrabold uppercase tracking-[0.08em]">{{ translate('Donate now!') }}</p>
                    </div>

                    {{-- ✅ DAF DIRECT SINGLE CONTAINER --}}
                    <div class="rounded-sm border border-gray-200 bg-white overflow-hidden">
                        <div id="dafdirectdiv">
                            <form name="dafdirect" id="dafdirect" method="post">
                                <img src="https://www.dafdirect.org/ddirect/images/logo-DAF-direct2.jpg" alt="{{ translate('DAF Direct Logo') }}" alt="{{ translate('DAF Direct Logo title') }}"><br>
                                <input type="hidden" name="dafdirect_token" id="dafdirect_token" value="4855c734-8078-4024-93f6-327fbfcf6035"><br>

                                <div class="whatThis">
                                    <a id="showwhatisthis" href="#">What is this?</a>
                                </div>

                                <div id="whatisthis" style="display:none;">
                                    <div class="dafdirectscroll">
                                        <p>A donor advised fund (DAF) is a charitable giving program that allows you to combine the most favorable tax benefits with the flexibility to support your favorite causes.</p>
                                        <p>If you have a donor advised fund, DAF Direct enables you to recommend grants to this nonprofit directly from your DAF (as long as your DAF's sponsoring organization is participating).</p>
                                    </div>
                                    <div class="dafdirectClearfix"></div>
                                    <div class="whatThis">
                                        <a id="closewhatisthis" href="#"><br>Close</a>
                                    </div>
                                </div>

                                <div id="notwhatisthis" style="display:block;">
                                    <label for="dafprovider">Donate now from:</label><br>
                                    <select name="dafprovider" id="dafprovider" class="dafdirectDonateFrom dafdirectDropdown dafdirectSelect">
                                        <option value="">--Please select--</option>
                                        <option value="FC">Fidelity Charitable</option>
                                        <option value="SC">DAFgiving360</option>
                                        <option value="BNYM">BNY Mellon</option>
                                    </select><br>

                                    <label for="dafdirect_dsgtxt">Designation:</label><br>
                                    <input class="dafdirectInputFull dafdirectInput" type="text" name="dafdirect_dsgtxt" id="dafdirect_dsgtxt" size="8" value="">

                                    <div id="amountNextContain">
                                        <div class="dafdirectInputAmount">
                                            <label for="dafdirect_amnt">Amount:</label><br>
                                            <input type="text" name="dafdirect_amnt" id="dafdirect_amnt" size="8" value="$" class="text-iput dafdirectInput">
                                        </div>

                                        <div class="dafdirectButtonContain">
                                            <a id="dafdirectsubmit" href="#">
                                                <img border="0" src="https://www.dafdirect.org/ddirect/images/button-next1.jpg" alt="Next">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </aside>

        </div>


    </div>
</section>

@include('frontend.includes.news_letter')

 <div class="py-5 bg-[#f6f6f6]"> 
      @include('frontend.includes.scroll_element')
  </div>

 

@once
    <link rel="stylesheet" type="text/css" href="https://www.dafdirect.org/ddirect/css/dafdirect2.1.css">   
@endonce

<script>
document.addEventListener('DOMContentLoaded', () => {
  // ✅ button (better: give it an id)
  const mobileDonateBtn = document.querySelector('.md\\:hidden');

  // ✅ আগেরটা যেটা hide হবে
  const articleDiv = document.querySelector('article.bg-white.border.border-gray-200.shadow-md.px-8');

  // ✅ এখন যেটা show হবে
  const donateBox = document.getElementById('donateBox');

  if (mobileDonateBtn && articleDiv && donateBox) {
    mobileDonateBtn.addEventListener('click', (e) => {
      e.preventDefault();

      // 1) hide previous
      articleDiv.classList.add('hidden');

      // 2) show new
      donateBox.classList.remove('hidden');

      // optional scroll
      donateBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  }
});
</script>


@endsection