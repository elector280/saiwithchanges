
    @php
        $storiesMain = \App\Models\Story::orderByDesc('view_count')->where('status','published')->take(1)->get();
        $storiesOther = \App\Models\Story::orderByDesc('view_count')->where('status','published')->skip(1)->take(4)->get();

        // Mobile slider-এর জন্য সব একসাথে
        $storiesAll = \App\Models\Story::orderByDesc('view_count')->where('status','published')->get();
    @endphp

    <!-- cards -->
    <div class="hidden md:px-4 lg:px-0 md:grid gap-6 mt-8 md:grid-cols-2 xl:grid-cols-3">

        
        @foreach($storiesMain as $item)
        <article class="flex flex-col overflow-hidden bg-white rounded-md shadow-xl text-slate-900 xl:col-span-2">
            <div class="relative">
                <img src="{{ asset('storage/story_image/'.$item->image) }}" alt="{{ $item->seo_title }}"
                    class="object-cover w-full h-52" />
                <div class="absolute left-0 right-16 -bottom-0">
                    <div class="rounded-tr-xl px-3 py-2 text-left"  style="background-color: {{ $item->category->active_bg_color ?? '' }}; color: {{ $item->category->active_text_color ?? 'black' }};">
                        <p class="text-[13px] font-bold leading-snug tracking-[0.08em] uppercase">
                            {{ \Illuminate\Support\Str::limit($item->title ?? '', 40) }}
                        </p>
                    </div>
                </div>
            </div>


            
            <!--<a href="{{ route('news', array_filter(['category' => $item->category->id, 'q' => request('q')])) }}"
                class="inline-flex items-center gap-1 px-4 py-1.5 text-sm font-semibold transition duration-200 hover:scale-105">
                    <i class="fa-solid fa-tag text-xs"></i>
                    {{ $item->category->name ?? '---' }}
            </a>-->

            <!-- content -->
            <div class="px-4 pt-8 pb-0 text-[12px] flex-1">
                <p class="leading-snug text-slate-600">
                    {{ \Illuminate\Support\Str::limit($item->short_description ?? '', 100) }}
                </p>
            </div>

            <!-- ✅ BIG FOOTER (NO BORDER) -->
            <div class="px-4 py-3 mt-auto bg-white">
            <div class="flex items-center justify-between text-[11px] text-slate-500">
                
                <!-- LEFT: Date -->
                <span class="whitespace-nowrap">
                    {{ $item->created_at->format('j M Y') }}
                </span>


                <!-- MIDDLE: Posted By + circle + Name -->
                <div class="flex items-center gap-2 whitespace-nowrap">
                    <span class="text-slate-400">{{ translate('Posted By') }}</span>
                    <span class="w-4 h-4 border border-slate-400 rounded-full"></span>
                    <span class="font-semibold uppercase tracking-[0.08em] text-slate-500">
                        {{ $item->user->name ?? '---' }}
                    </span>
                </div>

                <!-- RIGHT: Read more -->
                <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $item->slug) : route('blogDetails', $item->slug) }}"
                class="inline-flex items-center justify-center h-8 px-12 border border-[#ffb2b2]
                        text-[#ff8a8a] bg-white text-[12px] font-medium rounded-sm whitespace-nowrap"  style="border: 1px solid {{ $item->category->text_color ?? '#ffb2b2' }} !important;  color: {{ $item->category->text_color ?? '#ff8a8a' }} !important;">
                     {{ translate('Read more') }} &gt;
                </a>
            </div>
        </div>

        </article>
        @endforeach


        @foreach($storiesOther as $item)
        <article
            class="bg-white text-slate-900 border border-[#e5534b] rounded-md shadow-xl overflow-hidden flex flex-col">
            <div class="relative">
                <img src="{{ asset('storage/story_image/'.$item->image) }}" alt="{{ $item->title }}"
                    class="object-cover w-full h-52" />
                <div class="absolute left-0 right-16 -bottom-0">
                    <div class="bg-[#ffe9a8] rounded-tr-xl px-3 py-2 text-left"  style="background-color: {{ $item->category->active_bg_color ?? '' }}; color: {{ $item->category->active_text_color ?? 'black' }};">
                        <p class="text-[13px] font-semibold leading-snug tracking-[0.08em] uppercase">
                                {{ \Illuminate\Support\Str::limit($item->title ?? '', 40) }}
                        </p>
                    </div>
                </div>
            </div>

            <!--<a href="{{ route('news', array_filter(['category' => $item->category->id, 'q' => request('q')])) }}"
                class="inline-flex items-center gap-1 px-4 py-1.5 text-sm font-semibold transition duration-200 hover:scale-105">
                    <i class="fa-solid fa-tag text-xs"></i>
                    {{ $item->category->name ?? '---' }}
                </a>-->

            <div class="px-4 pt-8 pb-0 text-[12px] flex-1">
                <p class="leading-snug text-slate-600">
                    {{ \Illuminate\Support\Str::limit($item->short_description ?? '', 100) }}
                </p>
            </div>

            <!-- ✅ SMALL FOOTER (NO BORDER) -->
            <div class="px-4 py-3 mt-auto bg-white">
                <div class="flex items-center justify-between text-[11px] text-slate-500">
                    <div class="flex items-center gap-2">
                        <span>By</span>
                        <span class="w-4 h-4 border rounded-full border-slate-400"></span>
                        <span class="font-semibold uppercase tracking-[0.06em]">{{ $item->user->name ?? '---' }}</span>
                    </div>
                    <span>{{ $item->created_at->format('j M Y') }}</span>
                </div>

                <div class="mt-3"> 
                    <a href="{{ session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $item->slug) : route('blogDetails', $item->slug) }}"
                        class="inline-flex items-center justify-center h-8 px-12 border border-[#ffb2b2]
                            text-[#ff8a8a] bg-white text-[13px] font-medium rounded-sm"  style="border: 1px solid {{ $item->category->text_color ?? '#ffb2b2' }} !important;  color: {{ $item->category->text_color ?? '#ff8a8a' }} !important;">
                         {{ translate('Read more') }} &gt;
                    </a>
                </div>
            </div>
        </article>
        @endforeach

    </div>





                
    <!-- ✅ MOBILE CAROUSEL -->
    <div class="md:hidden mt-8 pl-4">

        <!-- header with arrows -->
        <div class="flex items-center justify-center gap-4 mb-4">
            <button type="button" id="newsPrev"
                class="w-10 h-10 rounded-full border border-white/60 flex items-center justify-center">
                ❮
            </button>

            <span class="uppercase tracking-widest text-sm">  {{ translate('Scroll Articles') }}</span>

            <button type="button" id="newsNext"
                class="w-10 h-10 rounded-full border border-white/60 flex items-center justify-center">
                ❯
            </button>
        </div>

        <!-- slider -->
        <div id="newsSlider"
            class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2"
            style="-webkit-overflow-scrolling: touch;"
        >
            @foreach($storiesAll as $item)
                <article class="min-w-[85%] snap-start bg-white text-slate-900 rounded-md shadow-xl overflow-hidden flex flex-col">
                    <div class="relative">
                        <img src="{{ asset('storage/story_image/'.$item->image) }}"
                            alt="{{ $item->title }}"
                            class="object-cover w-full h-52" />

                        <div class="absolute left-0 right-16 -bottom-0">
                            <div class="rounded-tr-xl px-4 py-3 text-left"
                                style="background-color: {{ $item->category->bg_color ?? '#ffe9a8' }}; color:black;">
                                <p class="text-[13px] font-semibold leading-snug tracking-[0.08em] uppercase">
                                    {{ \Illuminate\Support\Str::limit($item->title ?? '', 40) }}
                                </p>
                            </div>
                        </div>
                    </div> 


                    <div class="px-4 pt-8 pb-0 text-[12px] flex-1">
                        <p class="leading-snug text-slate-600">
                            {{ \Illuminate\Support\Str::limit($item->short_description ?? '', 100) }}
                        </p>
                    </div>

                    <div class="px-4 py-3 mt-auto bg-white">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span class="whitespace-nowrap">{{ $item->created_at->format('j M Y') }}</span>

                            <a href="{{ route('blogDetails', $item->slug) }}"
                            class="inline-flex items-center justify-center h-8 px-10 border border-[#ffb2b2]
                                    text-[#ff8a8a] bg-white text-[12px] font-medium rounded-sm whitespace-nowrap"  style="border: 1px solid red !important;">
                                 {{ translate('Read more') }} &gt;
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>



    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('newsSlider');
        const prev = document.getElementById('newsPrev');
        const next = document.getElementById('newsNext');

        if (!slider || !prev || !next) return;

        function scrollAmount() {
            // একবারে 1 card পরিমাণ scroll
            const card = slider.querySelector('article');
            return card ? (card.getBoundingClientRect().width + 16) : 300; // 16 = gap-4
        }

        prev.addEventListener('click', () => {
            slider.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
        });

        next.addEventListener('click', () => {
            slider.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
        });
    });
    </script>
