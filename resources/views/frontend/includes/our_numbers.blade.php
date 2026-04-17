    <!-- ================= OUR NUMBERS (IMAGE CLONE) ================= -->
{{-- ✅ OUR NUMBERS (matches screenshot + mobile responsive) --}}
<section class="py-6 lg:py-10 bg-[#f3f3f3]">
  <div class="max-w-6xl px-4 mx-auto">

    {{-- CARD --}}
    <div class="relative bg-white rounded-[6px] border border-slate-200
                shadow-[0_10px_25px_rgba(0,0,0,0.08)] overflow-hidden">

      {{-- TOP BAR (gray) --}}
      <div class="bg-gradient-to-b from-[#f7f7f7] to-[#f1f1f1] border-b border-slate-200">
        <div class="relative h-12 flex items-stretch">

          {{-- LEFT TAB --}}
          <div class="relative inline-flex items-center bg-[#e13b35] text-white
                      pl-6 pr-20 h-full rounded-tl-[6px] overflow-hidden">
            <span class="text-[13px] lg:text-sm font-semibold uppercase tracking-[0.20em]">
              {{ translate('OUR NUMBERS ') }}
            </span>

            {{-- slanted end (red) --}}
            <div class="absolute inset-y-0 right-14 w-10 bg-[#e13b35] -skew-x-[18deg] origin-bottom"></div>

            {{-- blue + yellow ribbon --}}
            <div class="absolute inset-y-0 right-0 w-20">
              <div class="absolute inset-y-0 right-10 w-10 bg-[#0047ab] -skew-x-[18deg] origin-bottom"></div>
              <div class="absolute inset-y-0 right-0  w-10 bg-[#ffcf34] -skew-x-[18deg] origin-bottom"></div>
            </div>
          </div>

          {{-- remaining gray area --}}
          <div class="flex-1"></div>
        </div>
      </div>

      {{-- DESCRIPTION --}}
      <div class="px-6 pt-6 pb-2 lg:px-10">
        <p class="max-w-2xl text-[15px] lg:text-[16px] leading-relaxed text-slate-500">
           @if(!empty($setting->our_numbers_content))
              {!! $setting->our_numbers_content !!}
          @endif
        </p>
      </div>

      {{-- STATS --}}
      <div class="px-6 pb-6 lg:px-10">
        <div class="grid gap-0 md:grid-cols-2 md:gap-x-14">

          {{-- ITEM 1 --}}
          <div class="flex items-center gap-6 py-7 border-b border-slate-300">
            <div class="w-16 h-16 rounded-[22px] border border-slate-300 flex items-center justify-center">
              <span class="text-[10px] uppercase tracking-widest text-slate-500">
                <i class="fa-solid fa-users text-slate-600 text-[20px]"></i>
              </span>
            </div>

            <div class="flex items-baseline gap-5">
              <span class="text-[44px] lg:text-[54px] font-semibold text-slate-700 leading-none">25k+</span>
              <span class="text-[18px] lg:text-[22px] text-slate-600">People Helped</span>
            </div>
          </div>

          {{-- ITEM 2 --}}
          <div class="flex items-center gap-6 py-7 border-b border-slate-300 md:border-b border-slate-300">
            <div class="w-16 h-16 rounded-[22px] border border-slate-300 flex items-center justify-center">
              <span class="text-[10px] uppercase tracking-widest text-slate-500">
                <i class="fa-solid fa-users text-slate-600 text-[20px]"></i>
              </span>
            </div>

            <div class="flex items-baseline gap-5">
              <span class="text-[44px] lg:text-[54px] font-semibold text-slate-700 leading-none">230</span>
              <span class="text-[18px] lg:text-[22px] text-slate-600">Volunteers</span>
            </div>
          </div>

          {{-- ITEM 3 --}}
          <div class="flex items-center gap-6 py-7 border-b border-slate-300 md:border-b-0">
            <div class="w-16 h-16 rounded-[22px] border border-slate-300 flex items-center justify-center">
              <span class="text-[10px] uppercase tracking-widest text-slate-500">
                <i class="fa-solid fa-users text-slate-600 text-[20px]"></i>
              </span>
            </div>

            <div class="flex items-baseline gap-5">
              <span class="text-[44px] lg:text-[54px] font-semibold text-[#1f5fbf] leading-none">365</span>
              <span class="text-[18px] lg:text-[22px] text-slate-600">Educated children</span>
            </div>
          </div>

          {{-- ITEM 4 --}}
          <div class="flex items-center gap-6 py-7">
            <div class="w-16 h-16 rounded-[22px] border border-slate-300 flex items-center justify-center">
              <span class="text-[10px] uppercase tracking-widest text-slate-500">
                <i class="fa-solid fa-users text-slate-600 text-[20px]"></i>
              </span>
            </div>

            <div class="flex items-baseline gap-5">
              <span class="text-[44px] lg:text-[54px] font-semibold text-slate-700 leading-none">250k</span>
              <span class="text-[18px] lg:text-[22px] text-slate-600">Served Meal</span>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- BOTTOM RIGHT LINK (outside card like screenshot) --}}
    <div class="mt-3 text-right">
      <a href="#" class="text-[#e13b35] text-[16px] lg:text-[20px] hover:underline underline-offset-4">
        Read More about us
      </a>
    </div>

  </div>
</section>
