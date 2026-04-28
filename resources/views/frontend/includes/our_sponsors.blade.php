<section class="pb-16 bg-white">
    <div class="max-w-7xl px-4 md:px-0 mx-auto text-center">
        <div class="text-[18px] md:text-2xl font-bold uppercase text-[#d93832]">
            {{ translate('OUR SPONSORS') }}
        </div>

        @php
            $sponsor = App\Models\Sponsor::where('type', 'sponsors')->latest()->get();
        @endphp

        @if($sponsor->count())
        <div class="mt-6 sponsor-marquee overflow-hidden">
            <div class="sponsor-track flex items-center gap-8 md:gap-10" id="sponsorTrack">
                {{-- Set 1 --}}
                @foreach($sponsor as $item)
                    <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}"
                        alt="{{ $item->company_name }}"
                        class="object-contain w-auto h-8 md:h-10 shrink-0" />
                @endforeach

                {{-- Set 2 (duplicate) --}}
                @foreach($sponsor as $item)
                    <img src="{{ asset('storage/company_logo/'.$item->company_logo) }}"
                        alt="{{ $item->company_name }}"
                        class="object-contain w-auto h-8 md:h-10 shrink-0" />
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
