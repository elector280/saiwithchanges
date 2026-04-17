  <div class="mt-2-">
        <p class="text-xl leading-tight lg:text-[28px] font-bold text-[#FE6668] uppercase text-center">
             {{ translate('OUR VALUES') }}
        </p>

        @php 
        $values = App\Models\OurValue::latest()->take(3)->get();
        @endphp
        <div class="grid gap-8 mt-6 md:grid-cols-3">
            



            @foreach($values as $item)
                <article class="overflow-hidden bg-white rounded-md h-[420px] flex flex-col">

                    
                    <!-- TOP IMAGE -->
                    <div class="relative">
                        <img src="{{ asset('storage/value_image/'.$item->image) }}"
                            class="object-cover w-full h-52"
                            style="filter: sepia(0.65) saturate(1.3);"
                            alt="{{ $item->title }}">
                        <!-- RIBBONS ... -->
                    </div>

                    <!-- CONTENT (fixed height area) -->
                    <div class="bg-[#f14f4f] text-white px-7 py-8 text-sm leading-relaxed flex-1 flex flex-col">
                        <h3 class="text-xl font-bold leading-snug uppercase line-clamp-2 min-h-[56px]">
                                {{ \Illuminate\Support\Str::limit($item->title, 60) }}
                        </h3>

                        <p class="mt-4 text-md text-[#ffe5e5] line-clamp-3 flex-1">
                            {{ \Illuminate\Support\Str::limit($item->description, 100) }}
                        </p>

                        {{-- optional: bottom spacing / button area consistent --}}
                        {{-- <div class="mt-4">...</div> --}}
                    </div>
                </article>
            @endforeach


        </div>
    </div>