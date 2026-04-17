<?php
    $schema = [
        "@context" => "https://schema.org",
        "@type"    => "Article",
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id"   => url()->current(),
        ],
        "headline" => $campaign->seo_title ?? $campaign->title ?? "Campaign",
        "description" => strip_tags($campaign->seo_description ?? $campaign->short_description ?? ""),
        "image" => !empty($campaign->hero_image)
            ? asset('storage/hero_image/'.$campaign->hero_image)
            : null,
        "author" => [
            "@type" => "Person",
            "name"  => optional($campaign->user)->name ?? "Admin",
        ],
        "publisher" => [
            "@type" => "Organization",
            "name"  => $setting->title ?? config("app.name", "NGO Website"),
            "logo"  => [
                "@type" => "ImageObject",
                "url"   => !empty($setting->logo) ? asset($setting->logo) : asset("favicon.ico"),
            ],
        ],
        "datePublished" => optional($campaign->created_at)->toIso8601String(),
        "dateModified"  => optional($campaign->updated_at)->toIso8601String(),
        "articleSection" => "Donation",
        "keywords" => ["donation","charity","help people","fundraising"],
        "inLanguage" => app()->getLocale() ?? "en",
        "isAccessibleForFree" => true,
    ];

    // null field remove (image null হলে বাদ যাবে)
    $schema = array_filter($schema, fn($v) => $v !== null);
?>

<script type="application/ld+json">
<?php echo json_encode($schema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE, 512) ?>
</script>
<?php /**PATH /home/saingo/public_html/resources/views/frontend/seo/campaign_details.blade.php ENDPATH**/ ?>