{!! '<' . '?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

@foreach($items as $item)
  <url>
    <loc>{{ $item['loc'] }}</loc>
    <lastmod>{{ $item['lastmod'] }}</lastmod>

    @if(!empty($item['alts']))
      @foreach($item['alts'] as $alt)
        <xhtml:link rel="alternate" hreflang="{{ $alt['lang'] }}" href="{{ $alt['href'] }}"/>
      @endforeach
    @endif
  </url>
@endforeach

</urlset>
