


<footer class="bg-[#2b2b2b] text-[#d3d7e0] pt- text-[11px] sm:text-xs">
    <!-- ASK US floating button -->
      {{--
    <button id="askUsToggle"
        class="fixed right-4 bottom-6 z-20 w-16 h-16 rounded-full bg-white
               shadow-[0_8px_25px_rgba(0,0,0,0.18)] border uppercase tracking-[0.14em]
               flex items-center justify-center text-[#ff6b6b] font-semibold">
         {{ translate('ASK US') }}
    </button>
    --}}

    <button id="scrollToTop" class="fixed bottom-6 right-6 items-center justify-center w-12 h-12 rounded-full bg-[#D94647] text-white shadow-lg hover:bg-[#D94647] transition-all duration-300 flex" aria-label="Scroll to top">
        ↑
    </button> 

    <div class="relative max-w-7xl px-4 mx-auto md:py-5">
        <!-- CHAT BOX -->
        
        <div id="chatBox" class="fixed bottom-16 w-80 z-30 text-slate-800 text-[11px] hidden right-16 sm:right-[210px]">
        <div class="bg-white rounded-[12px] shadow-2xl border border-[#e95858] overflow-hidden">

            <div class="flex items-center justify-between bg-[#e95858] text-white px-4 py-2 text-[11px] font-semibold rounded-t-[12px]">
            <span> {{ translate('CHAT WITH US') }}</span>
            <button class="text-xs leading-none chat-close" aria-label="Collapse chat">✕</button>
            </div>

            <div id="chatMessages" class="px-3 py-3 space-y-3 bg-white max-h-[320px] overflow-y-auto"></div>

            <div class="border-t border-slate-200">
            <div class="flex items-center bg-[#eaf1ff] px-2 py-2">
                <input id="chatInput" type="text" placeholder="Type something to start a chat"
                    class="flex-1 bg-transparent outline-none text-[11px] placeholder:text-slate-500" />
                <button id="chatSendBtn"
                        class="ml-2 w-6 h-6 rounded-full bg-[#2d6cdf] flex items-center justify-center text-white text-[11px]">
                ➤
                </button>
            </div>
            </div>

        </div>
        </div>


        {{-- ================= MOBILE FOOTER (like screenshot) ================= --}}
        <div class="lg:hidden">
            <div class="flex flex-col items-center text-center">
                <img src="{{ asset('images/logo/logo3.png') }}" class="h-[70px] w-auto object-contain mt-4"
                    alt="South American Initiative" />

                <div class="w-full mt-6">
                    <div class="h-px bg-white/20"></div>
                    <p class="mt-4 uppercase sm:text-xl text-white/70">
                        {{ translate('Our Certifications') }}
                    </p>
                    @php 
                        $certifications = App\Models\Sponsor::where('type', 'certifications')->latest()->get();
                    @endphp

                    <div class="flex flex-wrap items-center justify-center gap-4 mt-4">
                        @foreach($certifications as $item)
                        <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}" alt="{{ $item->company_name }}" title="{{ $item->company_name }}" class="object-contain w-auto h-8" />
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-3 gap-3 text-[11px]">
                <div>
                    <h3 class="font-semibold uppercase text-white/80">{{ translate('Website') }}</h3>
                    <ul class="mt-3 space-y-2 text-white/70">
                        <li><a href="{{ route('homees') }}" class="hover:underline"> {{ translate('Home') }}</a></li>
                        <li><a href="{{ route('aboutUs') }}" class="hover:underline"> {{ translate('About us') }}</a></li>
                        <li><a href="{{ route('campaigns') }}" class="hover:underline"> {{ translate('Explore campaign') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold uppercase text-white/80"> {{ translate('Contacts Info') }}</h3>
                    <ul class="mt-3 space-y-2 text-white/70">
                        <li>{{ $setting->email }}</li>
                        <li>{{ $setting->telephone }}</li>
                        <li class="leading-relaxed">
                            {{ $setting->address }}
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold uppercase text-white/80">Donations {{ translate('Donation') }}</h3>
                    <ul class="mt-3 space-y-2 text-white/70">
                        <li><a href="{{ route('donation') }}" class="hover:underline"> {{ translate('Donate') }}</a></li> 
                        <li><a href="{{ route('doubleDonation') }}" class="hover:underline">{{ translate('Double Donation') }}</a></li>
                        <li><a href="{{ route('dafDonation') }}" class="hover:underline"> {{ translate('DAF Donation') }}</a></li>
                    </ul>
                </div>
            </div>

            <p class="mt-10 text-[12px] leading-relaxed text-white/70">
                @if(!empty($setting->description))
                    {!! $setting->description !!}
                @endif                
            </p>
        </div>

        {{-- ================= DESKTOP FOOTER (your existing) ================= --}}
        <div class="hidden lg:grid gap-10 lg:grid-cols-[1.7fr,1.7fr]">
            <!-- LEFT SIDE -->
            <div class="text-left">
                <div class="flex flex-col md:flex-row md:items-center md:gap-10">
                    <div class="flex justify-center mb-4 md:justify-start md:mb-0">
                        <img src="{{ asset('images/logo/logo3.png') }}" class="h-[80px] w-auto object-contain"
                            alt="{{ translate('South American Initiative alt') }}"/>
                    </div>

                    <div class="flex flex-col items-center md:items-start">
                        <span class="mb-3 text-xl text-white uppercase">{{ translate('Our Certifications') }}</span>

                        <div class="flex flex-wrap items-center gap-3">
                            @foreach($certifications as $item)
                            <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}" class="object-contain w-auto h-8" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <p class="mt-5 leading-relaxed max-w-md text-[14px] sm:text-[15px]">
                    @if(!empty($setting->description))
                        {!! $setting->description !!}
                    @endif
                </p>
            </div>

            <!-- RIGHT SIDE -->
            <div class="lg:border-t lg:border-[#4b4b4b] lg:pt-4">
                <div class="grid gap-8 sm:grid-cols-[1.1fr,1.2fr,1.5fr]">

                    <!-- WEBSITE LINKS -->
                    <div>
                        <h3 class="font-semibold text-[#FE6668] text-[14px] uppercase"> {{ translate('Website') }}</h3>
                        <ul class="mt-3">
                            <li class="mt-3"><a href="{{ route('homees') }}" class="hover:underline text-[15px]"> {{ translate('Home') }}</a></li>
                            <li class="mt-3"><a href="{{ route('aboutUs') }}" class="hover:underline text-[15px]">{{ translate('About us ') }}</a></li>
                            <li class="mt-3"><a href="{{ route('campaigns') }}" class="hover:underline text-[15px]"> {{ translate('Campaigns') }}</a></li>
                        </ul>

                    </div>

                    <!-- EMAIL & PHONE -->
                    <div>
                        <h3 class="font-semibold text-[#FE6668] text-[11px] uppercase"> {{ translate('Email Address') }}</h3>
                        <p class="mt-2 text-white">{{ $setting->telephone }}</p>

                        <h3 class="mt-4 font-semibold text-[#FE6668] text-[11px] uppercase mt-2"> {{ translate('Telephone') }}</h3>
                        <p class="mt-1">{{ $setting->email }}</p>
                    </div>

                    <!-- ADDRESS + SOCIAL MEDIA CHANNELS -->
                    <div>
                        <h3 class="font-semibold text-[#FE6668] text-[11px] uppercase"> {{ translate('Address') }}</h3>
                        <p class="mt-1 leading-relaxed whitespace-pre-line">
                            @if(!empty($setting->address))
                                {!! $setting->address !!}
                            @endif
                        </p>

                        <!-- SOCIAL MEDIA CHANNELS + EMAIL FORM -->
                        <div class="mt-6">
                            <p class="text-[11px] font-semibold uppercase text-[#ff7f7f]">
                                 {{ translate('Subscribe To Newsletter') }}
                            </p>
                             
                           <form class="newsletterForm w-full max-w-xs mt-3" action="{{ route('newsletter.subscribe') }}" method="post">
                                @csrf

                                <div class="flex items-center bg-white rounded-full overflow-hidden shadow-[0_2px_6px_rgba(0,0,0,0.25)]">
                                    <input type="email" name="email" placeholder="Insert Your best email"
                                        class="flex-1 px-3 py-2 text-[11px] text-slate-700 border-0 outline-none placeholder:text-slate-400" />

                                    <button type="submit"
                                            class="newsletterBtn px-5 py-2 text-[11px] font-semibold uppercase bg-[#ff6e6e] text-white whitespace-nowrap hover:bg-[#ff5959] transition">
                                        {{ translate('Send Email') }} &gt;
                                    </button>
                                </div>

                                <!-- ✅ response message per form -->
                                <p class="newsletterMsg mt-2 text-[11px]"></p>
                            </form>

                            @if(session('success'))
                                <p
                                    class="mt-2 rounded-md
                                            px-4- py-0 text-sm text-emerald-300">
                                    {{ session('success') }}
                                </p>
                            @endif
                            @error('email')
                                <p
                                    class="mt-2 rounded-md
                                            px-4- py-0 text-sm text-emerald-300">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</footer>


<script>
    const scrollBtn = document.getElementById('scrollToTop');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 200) {
            scrollBtn.classList.remove('hidden');
            scrollBtn.classList.add('flex');
        } else {
            scrollBtn.classList.add('hidden');
            scrollBtn.classList.remove('flex');
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
