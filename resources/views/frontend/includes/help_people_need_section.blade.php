<div class="mt-8 border border-gray-200 overflow-hidden">
  <div class="grid md:grid-cols-2">
    <div class="bg-[#f04848] text-white p-6">
      <p class="text-[10px] font-bold uppercase opacity-90">
            {{ translate('Help people in need') }} 
      </p>
      <h3 class="mt-2 text-[16px] md:text-[18px] font-extrabold uppercase leading-snug">
          {!! translate('Start donating today') !!} 
      </h3> 
      <a href="#" class="inline-flex mt-4 items-center justify-center bg-white text-[#f04848] px-5 py-2 text-[11px] font-extrabold uppercase">
        {{ translate('Donate to this project') }}
      </a>
    </div>

    <div class="relative h-40 md:h-auto">
      <img
        src="{{ asset('storage/campaign_cover_image/'.$setting->campaign_cover_image) }}"
        class="w-full h-full object-cover"
        alt="Help people in need">
      <div class="absolute inset-0 bg-[#f04848]/25"></div>
    </div>
  </div>
</div>