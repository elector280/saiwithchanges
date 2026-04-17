<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

use App\Models\Campaign;
use App\Models\Story;
use App\Models\MiniCampaign;
use App\Models\WebsiteSetting;

class SitemapController extends Controller
{
    public function index()
    {
        $setting = WebsiteSetting::first();

        // Serve uploaded sitemap if exists
        if ($setting && $setting->sitemap_file) {
            $path = 'sitemap_file/' . $setting->sitemap_file;

            if (Storage::disk('public')->exists($path)) {
                $xml = Storage::disk('public')->get($path);

                return response($xml, 200)
                    ->header('Content-Type', 'application/xml; charset=UTF-8');
            }
        }

        // Otherwise generate dynamically
        $xml = $this->generateSitemap();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    private function generateSitemap()
    {
        $urls = [];

        // Homepage
        $urls[] = $this->altSet(
            url('/'),
            url('/es/home'),
            now()
        );

        // Campaigns
        $campaigns = Campaign::where('status', 'published')->get();

        foreach ($campaigns as $campaign) {
            $slugEn = $this->pickLocaleValue($campaign->slug, 'en');
            $slugEs = $this->pickLocaleValue($campaign->slug, 'es') ?? $slugEn;

            $pathEn = $this->pickLocaleValue($campaign->path, 'en') ?? 'project';
            $pathEs = $this->pickLocaleValue($campaign->path, 'es') ?? 'proyecto';

            if (!$slugEn) continue;

            $urls[] = $this->altSet(
                url("$pathEn/$slugEn"),
                url("/es/$pathEs/$slugEs"),
                $campaign->updated_at
            );
        }

        // Stories
        $stories = Story::where('status', 1)->get();

        foreach ($stories as $story) {
            $slugEn = $this->pickLocaleValue($story->slug, 'en');
            $slugEs = $this->pickLocaleValue($story->slug, 'es') ?? $slugEn;

            if (!$slugEn) continue;

            $urls[] = $this->altSet(
                url("report/$slugEn"),
                url("es/informe/$slugEs"),
                $story->updated_at
            );
        }

        // Mini campaigns
        if (class_exists(MiniCampaign::class)) {
            $miniCampaigns = MiniCampaign::where('status', 1)->get();

            foreach ($miniCampaigns as $mini) {
                $slug = $mini->slug ?? null;
                if (!$slug) continue;

                $urls[] = $this->altSet(
                    url("mini-campaign/$slug"),
                    url("es/mini-campaign/$slug"),
                    $mini->updated_at
                );
            }
        }

        return $this->buildXml($urls);
    }

    private function buildXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
                         xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . e($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';

            foreach ($url['alts'] as $alt) {
                $xml .= '<xhtml:link rel="alternate" hreflang="' . $alt['lang'] . '" href="' . e($alt['href']) . '" />';
            }

            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }

    private function altSet(string $enUrl, string $esUrl, $lastmod): array
    {
        $lastmod = optional($lastmod)->toAtomString() ?? now()->toAtomString();

        return [
            'loc' => $enUrl,
            'lastmod' => $lastmod,
            'alts' => [
                ['lang' => 'en', 'href' => $enUrl],
                ['lang' => 'es', 'href' => $esUrl],
                ['lang' => 'x-default', 'href' => $enUrl],
            ],
        ];
    }

    private function pickLocaleValue($value, string $locale): ?string
    {
        if (is_array($value)) {
            return $value[$locale] ?? ($value['en'] ?? reset($value)) ?? null;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded[$locale] ?? ($decoded['en'] ?? reset($decoded)) ?? null;
            }
            return $value;
        }

        return null;
    }

    private function hasColumn(string $table, string $column): bool
    {
        try {
            return Schema::hasColumn($table, $column);
        } catch (\Throwable $e) {
            return false;
        }
    }
}