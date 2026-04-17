<?php
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'NewsArticle',

        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => url()->current(),
        ],

        'headline' => $story->title ?? 'Story',
        'description' => strip_tags($story->short_description ?? ''),

        'image' => !empty($story->hero_image)
            ? asset('storage/hero_image/'.$story->hero_image)
            : null,

        'author' => [
            '@type' => 'Person',
            'name'  => optional($story->user)->name ?? 'Admin',
        ],

        'publisher' => [
            '@type' => 'Organization',
            'name'  => $setting->title ?? config('app.name', 'NGO Website'),
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => !empty($setting->logo)
                    ? asset($setting->logo)
                    : (
                        !empty($setting->favicon)
                            ? asset('storage/favicon/'.$setting->favicon)
                            : asset('favicon.ico')
                    ),
            ],
        ],

        'datePublished' => optional($story->created_at)->toIso8601String(),
        'dateModified'  => optional($story->updated_at)->toIso8601String(),

        'articleSection' => 'Campaign Report',
        'keywords'       => ['donation','charity','help people','fundraising'],
        'inLanguage'     => app()->getLocale() ?? 'en',
        'isAccessibleForFree' => true,
    ];

    // image null হলে key বাদ যাবে (clean output)
    $schema = array_filter($schema, fn($v) => $v !== null);
?>

<script type="application/ld+json">
<?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>

</script>
<?php /**PATH /home/saingo/public_html/resources/views/frontend/seo/blog_details.blade.php ENDPATH**/ ?>