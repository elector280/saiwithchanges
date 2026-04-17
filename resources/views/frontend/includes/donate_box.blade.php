<aside id="campaignSidebar" aria-label="Donation and newsletter sidebar"
  class="hidden lg:flex lg:flex-col gap-5 w-full">

  <h2 class="sr-only">Donation and newsletter</h2>

  @if(!empty($campaign->donorbox_code))
    <div class="w-full max-w-none bg-white border border-gray-200 rounded-sm shadow-md overflow-hidden
                md:mx-0 md:w-full md:max-w-none
                [&_iframe]:!w-full [&_iframe]:!max-w-none [&_iframe]:block">
      {!! $campaign->donorbox_code !!}
      <noscript><p>Please enable JavaScript to donate.</p></noscript>
    </div>
  @endif

  <div class="bg-gradient-to-b from-[#ff5c5c] to-[#f48a4b] rounded-sm shadow-md p-5 text-white text-xs">
    <div class="font-bold text-[11px] uppercase tracking-[0.03em] mb-2">
      {{ translate('Help Venezuelan refugees') }}
    </div>

    <h4 class="text-xl font-semibold mb-3">
      {{ translate('SUBSCRIBE CAMPAIGN NEWSLETTER') }}
    </h4>

    <form action="{{ route('newsletter.subscribe') }}" method="post" class="newsletterForm w-full max-w-[560px] relative">
      @csrf

      <p class="newsletterMsg mb-2 rounded-md px-4 my-2 py-2 text-sm hidden" role="status" aria-live="polite"></p>

      <label for="newsletterEmail" class="sr-only">{{ translate('Email address') }}</label>
      <input id="newsletterEmail" type="email" name="email" required autocomplete="email"
        class="newsletterEmail w-full px-3 py-2 text-[11px] rounded-sm text-gray-800 mb-3"
        placeholder="{{ translate('Your email') }}">

      <button type="submit" aria-label="Subscribe to campaign newsletter"
        class="newsletterBtn w-full bg-white text-[#f04848] text-[13px] font-bold uppercase py-2 rounded-sm">
        {{ translate('Send email') }} &gt;
      </button>
    </form>
  </div>
</aside>


{{-- ✅ donorbox / iframe কে sidebar width অনুযায়ী fit করাতে --}}
<style>
  #campaignSidebar iframe{
    width: 100% !important;
    max-width: 100% !important;
    border: 0 !important;
    display: block !important;
  }
</style>



