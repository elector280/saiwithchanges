

<div id="galleryLightbox" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
  {{-- backdrop --}}
  <div id="galleryBackdrop" class="absolute inset-0 bg-black/70"></div>

  {{-- modal wrapper (responsive center) --}}
 <div class="relative z-10 min-h-screen w-full flex justify-center
            items-start md:items-center
            pt-20 md:pt-25
            px-2 sm:px-4 md:px-6
            pb-6"> 
    
    {{-- modal --}}
    <div class="relative w-full max-w-6xl bg-white rounded-md shadow-xl
            mt-5 md:mt-0
            max-h-[calc(100vh-5rem)] md:max-h-[90vh]
            overflow-y-auto overflow-x-hidden">


            {{-- close --}}
            <button id="closeGalleryBtn"
                class="absolute top-3 right-3 w-9 h-9 rounded-sm bg-[#f04848] text-white
                       flex items-center justify-center hover:bg-[#2261aa] z-20">
                ✕
            </button>

            {{-- ✅ TWO COLUMN --}}
            <div class="grid grid-cols-1 md:grid-cols-[1.6fr,1fr]">

                {{-- LEFT: BIG IMAGE --}}
                <div class="bg-black/10 p-3 md:p-4">
                    <img id="galleryMainImage"
                        class="w-full h-[300px] md:h-[420px] object-cover rounded-sm"
                        src="" alt="">

                    {{-- ✅ Caption under image --}}
                    <p id="galleryCaption"
                    class="mt-2 text-sm text-gray-600 text-center"></p>
                </div>


                {{-- RIGHT: INFO PANEL --}}
                <div class="p-4 md:p-6 border-l border-gray-200 flex flex-col">
                    <div class="text-sm text-gray-500">
                         {{ translate('Posted in') }} <i class="fas fa-circle"></i>
                        <span class="font-semibold text-gray-700" id="galleryCampaignTitle"></span>
                    </div>

                    <p id="galleryDescription" class="mt-2 text-sm text-gray-600 leading-6"></p>

                    {{-- Optional title under description --}}
                    <h4 id="galleryTitle" class="mt-4 font-semibold text-gray-800 text-sm"></h4>

                    <div class="flex-1"></div>

                    {{-- dots + share (optional) --}}
                    {{-- ✅ Colorful Social Icons --}}
                    <div class="flex items-center gap-3 mt-4">

                        {{-- Facebook --}}
                        @if(!empty($setting->fb_url))
                            <a href="{{ $setting->fb_url }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center
                                    text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition"
                            aria-label="Facebook" title="Facebook">
                                <i class="fab fa-facebook-f text-[15px]"></i>
                            </a>
                        @endif

                        {{-- Twitter / X --}}
                        @if(!empty($setting->twitter_url))
                            <a href="{{ $setting->twitter_url }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center
                                    text-blue-900 hover:bg-blue-900 hover:text-white transition"
                            aria-label="Twitter / X" title="X">
                                {{-- যদি X icon না থাকে, fa-twitter use করুন --}}
                                <i class="fab fa-x-twitter text-[15px]"></i>
                                {{-- <i class="fab fa-twitter text-[15px]"></i> --}}
                            </a>
                        @endif

                        {{-- Instagram --}}
                        @if(!empty($setting->instragram_url))
                            <a href="{{ $setting->instragram_url }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center
                                    text-[#E1306C] hover:bg-[#E1306C] hover:text-white transition"
                            aria-label="Instagram" title="Instagram">
                                <i class="fab fa-instagram text-[15px]"></i>
                            </a>
                        @endif

                        {{-- YouTube --}}
                        @if(!empty($setting->youtube_url))
                            <a href="{{ $setting->youtube_url }}" target="_blank" rel="noopener"
                            class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center
                                    text-[#FF0000] hover:bg-[#FF0000] hover:text-white transition"
                            aria-label="YouTube" title="YouTube">
                                <i class="fab fa-youtube text-[15px]"></i>
                            </a>
                        @endif

                        
                            <a id="galleryDetailsBtn"
                                href="#"
                                target="_blank"
                                rel="noopener"
                                class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center
                                        text-[15px] bg-red-600 text-white hover:bg-red-800 transition hidden"
                                aria-label="Gallery"
                                title="Gallery image details">
                                    <i class="fas fa-eye"></i>
                            </a>


                    </div>


                </div>
            </div>

            {{-- ✅ BOTTOM NAV --}}
            <div class="bg-white border-t border-gray-200 px-4 py-3 flex items-center justify-between">
                <button id="prevGalleryBtn" aria-label="Previous image"
                        class="px-3 py-1.5 text-sm border border-gray-300 rounded-sm hover:bg-gray-50">
                    ◀
                </button>

                <div class="text-xs text-gray-500">
                    <span id="galleryCounter">1 / 1</span>
                </div>

                <button id="nextGalleryBtn" aria-label="Next image"
                        class="px-3 py-1.5 text-sm border border-gray-300 rounded-sm hover:bg-gray-50">
                    ▶
                </button>
            </div>

            {{-- ✅ THUMB STRIP --}}
            <div class="bg-white px-4 py-3 border-t">
                <div id="galleryThumbs" class="flex gap-2 overflow-x-auto"></div>
            </div>

        </div>
    </div>
</div>



