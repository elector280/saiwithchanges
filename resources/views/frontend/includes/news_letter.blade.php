{{-- ================= NEWSLETTER (IMAGE MATCH + MOBILE RESPONSIVE) ================= --}}
<section class="pt-10 lg:pt-10 bg-[#f6f6f6]">
  <div class="max-w-7xl md:mx-auto md:px-4 lg:px-0 px-2- md:px-4-">
    
    <div class="relative overflow-hidden rounded-[8px] shadow-[0_14px_35px_rgba(0,0,0,0.12)] bg-white">

    

      {{-- TOP RED PANEL --}}
      <div class="relative bg-[#F56161] text-white
                  px-2 sm:px-8 lg:px-10
                  pt-8 pb-10 lg:py-12">

                  <div class="absolute top-0 -right-14 hidden w-16 h-full md:block">
                <div class="absolute inset-y-0 right-5 w-7 bg-[#2261aa] skew-x-[42deg]">  </div>
                <div class="absolute inset-y-0 right-0 w-6 bg-[#fff0a1] skew-x-[42deg]">  </div>
            </div>

        

        <div class="grid gap-6 lg:grid-cols-[1.15fr,1fr] items-center">
          {{-- LEFT: logo + text --}}
          <div class="flex items-start gap-5 lg:ml-4">
            <div class="hidden sm:flex shrink-0 w-[90px] h-[90px] items-center justify-center">
              <img src="{{ asset('images/Logo-Symbol.png') }}" alt="HELP VENEZUELAN REFUESS" class="w-[80px] h-auto" />
            </div>

            <div class="sm:pt-1">
              <p class="text-[16px] sm:text-[20px] uppercase tracking-[0.16em]- text-[#FEE79D] font-semibold">
                 {{ translate('HELP VENEZUELAN REFUESS') }}
              </p>

              <h2 class="mt-3 text-[26px] sm:text-[34px] lg:text-[40px] leading-[1.05] font-semibold uppercase">
                {!! translate('SUSCRIBE TO OUR NEWSLETTER') !!}
              </h2>
            </div>
          </div>

         {{-- RIGHT: desktop input (long) --}}
<div class="hidden lg:flex justify-end md:mr-10">
  <form action="{{ route('newsletter.subscribe') }}" method="post"
      class="newsletterForm w-full max-w-[560px] relative">
    @csrf

    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
           class="newsletterEmail w-full h-10 rounded-[6px] bg-white text-slate-800
                  px-6 pr-44 shadow-[0_10px_18px_rgba(0,0,0,0.22)]
                  focus:outline-none focus:ring-2 focus:ring-[#E26571]
                  placeholder:text-slate-400" />

    <button type="submit"
            class="newsletterBtn absolute top-5 -translate-y-1/2 right-3
                   h-6 px-6 rounded-[6px]
                   bg-[#E26571] hover:bg-[#d45763]
                   text-white text-[11px]
                   font-semibold uppercase tracking-[0.16em]
                   transition">
        {{ translate('Subscribe') }}
    </button>

    <!-- ✅ message output -->
    <p class="newsletterMsg mt-2 text-[11px] text-white"></p>
</form>

</div>


{{-- TABLET input (md only) --}}
{{-- TABLET ONLY --}}
<div class="hidden md:block lg:hidden w-full px-4">
  <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w-full max-w-[720px] mx-auto">
    @csrf

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
      <p class="mb-3 rounded-md bg-green-50 border border-green-200 px-4 py-2 text-sm text-green-700">
        {{ session('success') }}
      </p>
    @endif

    {{-- ERROR MESSAGE --}}
    @error('email')
      <p class="mb-3 rounded-md bg-red-50 border border-red-200 px-4 py-2 text-sm text-red-600">
        {{ $message }}
      </p>
    @enderror

    <div class="relative">
      <input
        type="email"
        name="email"
        value="{{ old('email') }}"
        placeholder="Enter your email"
        class="w-full h-14 rounded-xl bg-white text-slate-800
               pl-6 pr-[170px]
               shadow-[0_14px_26px_rgba(0,0,0,0.25)]
               focus:outline-none focus:ring-2 focus:ring-white/70
               placeholder:text-slate-400"
      />

      <button
        type="submit"
        class="absolute top-1/2 -translate-y-1/2 right-2
               h-10 px-8 rounded-lg
               bg-red-600 hover:bg-red-700
               border border-white/40
               text-white text-[12px]
               font-semibold uppercase tracking-[0.18em]
               backdrop-blur-sm transition"
      >
        {{ translate('Subscribe') }}
      </button>
    </div>
  </form>
</div>



{{-- MOBILE input (stacked) --}}
<div class="md:hidden">
    <form class="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="post">
    @csrf

    <input type="email" name="email" value="{{ old('email') }}" placeholder="Insert Your email"
           class="newsletterEmail w-full h-12 rounded-[6px] bg-white text-slate-800
                  px-5 shadow-[0_10px_18px_rgba(0,0,0,0.22)]
                  focus:outline-none placeholder:text-slate-400" />

    <button type="submit"
            class="newsletterBtn mt-4 inline-flex items-center justify-center
                   w-[160px] h-11 rounded-[6px]
                   border border-white/80 text-white
                   bg-[#ff6c6c]/20 backdrop-blur
                   text-[12px] font-semibold uppercase tracking-[0.14em]">
        {{ translate('Send Email') }} &gt;
    </button>

    <!-- ✅ message দেখানোর জায়গা -->
    <p class="newsletterMsg mt-2 text-[11px]"></p>
</form>

</div>

        </div>
      </div>

      {{-- BOTTOM BAR --}}
      <div class="bg-[#fdeeee] px-5 sm:px-8 lg:px-10 py-6">

    {{-- ✅ MOBILE (prototype like) --}}
    <div class="sm:hidden text-center">

        {{-- WhatsApp icon top --}}
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp_number) }}?text={{ urlencode('Hello, I want to know more details.') }}"
           target="_blank"
           class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#5dd35f] mx-auto">
            <i class="fab fa-whatsapp text-white text-3xl"></i>
        </a>

        {{-- whatsapp text --}}
        <div class="mt-3">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp_number) }}?text={{ urlencode('Hello, I want to know more details.') }}"
               target="_blank"
               class="uppercase font-semibold text-[#1f66c2] underline underline-offset-4">
                  {{ translate('Contact us on whatsapp') }} &gt;
            </a>
        </div>

        {{-- divider --}}
        <div class="my-5 h-px w-full bg-[#f2b6b6]"></div>

        {{-- social icons --}}
        <div class="flex items-center justify-center gap-4">
            <a href="{{ $setting->fb_url }}" target="_blank"
               class="w-10 h-10 rounded-lg bg-[#ff8b73] flex items-center justify-center">
                <i class="fab fa-facebook-f text-white text-xl"></i>
            </a>
            <a href="{{ $setting->twitter_url }}" target="_blank"
               class="w-10 h-10 rounded-lg bg-[#7ea7e6] flex items-center justify-center">
                <i class="fab fa-twitter text-white text-xl"></i>
            </a>
            <a href="{{ $setting->instragram_url }}" target="_blank"
               class="w-10 h-10 rounded-lg bg-[#ff6b79] flex items-center justify-center">
                <i class="fab fa-instagram text-white text-xl"></i>
            </a>
            <a href="{{ $setting->youtube_url }}" target="_blank"
               class="w-10 h-10 rounded-lg bg-[#1f66c2] flex items-center justify-center">
                <i class="fab fa-youtube text-white text-xl"></i>
            </a>
        </div>

        {{-- follow text --}}
        <div class="mt-4">
            <a href="#"
               class="text-[#1f66c2] text-[16px] underline underline-offset-4">
                {{ translate('Follow us on our social media') }}
            </a>
        </div>
    </div>


    {{-- ✅ DESKTOP (unchanged as you had) --}}
    <div class="hidden sm:flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

        {{-- WhatsApp --}}
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp_number) }}?text={{ urlencode('Hello, I want to know more details.') }}"
           class="inline-flex items-center gap-3 font-semibold text-[#007c2e]" target="_blank">
            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-[#5dd35f]">
                <i class="fab fa-whatsapp text-white text-3xl"></i>
            </span>
            <span class="uppercase"> {{ translate('Contact us on whatsapp') }} &gt; </span>
        </a>

        {{-- Divider (desktop) --}}
        <span class="hidden sm:block h-6 w-px bg-[#f2b6b6]"></span>

        {{-- Social --}}
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 text-[16px]">
                <a href="{{ $setting->fb_url }}" class="text-[#1877F2]" target="_blank"><i class="fab fa-facebook-f text-3xl"></i></a>
                <a href="{{ $setting->twitter_url }}" class="text-[#1DA1F2]" target="_blank"><i class="fab fa-twitter text-3xl"></i></a>
                <a href="{{ $setting->instragram_url }}" class="text-[#E4405F]" target="_blank"><i class="fab fa-instagram text-3xl"></i></a>
                <a href="{{ $setting->youtube_url }}" class="text-[#FF0000]" target="_blank"><i class="fab fa-youtube text-3xl"></i></a>
            </div>
            <a href="#" class="text-[#1f66c2] text-[16px] underline-offset-2 hover:underline">
                {{ translate('Follow us on our social media') }}
            </a>
        </div>
    </div>

</div>


    </div>
  </div>
</section>
