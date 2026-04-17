<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MiniCampaignController extends Controller
{
    public function storePreview(Request $request)
    {
        $token = Str::uuid()->toString();
        $locale = session('locale', config('app.locale'));

        $previewData = $request->except(['_token', '_method']);

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('temp-preview/cover_image', 'public');
            $previewData['__temp_cover_image'] = $coverPath;
        } else {
            $previewData['__existing_cover_image'] = $request->input('__existing_cover_image');
        }

        if ($request->hasFile('og_image')) {
            $ogPath = $request->file('og_image')->store('temp-preview/og_image', 'public');
            $previewData['__temp_og_image'] = $ogPath;
        } else {
            $previewData['__existing_og_image'] = $request->input('__existing_og_image');
        }

        $previewData['__locale'] = $locale;
        $previewData['__created_at'] = now()->toDateTimeString();

        Cache::put('mini_campaign_preview_' . $token, $previewData, now()->addMinutes(30));

        return redirect()->route('campaigns.miniCampaignPreview.show', $token);
    }

    public function showPreview(string $token)
    {
        $preview = Cache::get('mini_campaign_preview_' . $token);
        abort_unless($preview, 404);

        $locale = $preview['__locale'] ?? session('locale', config('app.locale'));

        $cam = new \stdClass();

        $cam->title = $preview['title'][$locale] ?? '';
        $cam->slug = $preview['slug'][$locale] ?? '';
        $cam->short_description = $preview['short_description'][$locale] ?? '';
        $cam->paragraph_one = $preview['paragraph_one'][$locale] ?? '';
        $cam->paragraph_two = $preview['paragraph_two'][$locale] ?? '';
        $cam->donation_box = $preview['donation_box'][$locale] ?? '';
        $cam->view_project_url = $preview['view_project_url'] ?? '';
        $cam->tag_line = $preview['tag_line'] ?? '';

        $cam->meta_title = $preview['meta_title'][$locale] ?? '';
        $cam->meta_description = $preview['meta_description'][$locale] ?? '';
        $cam->meta_keywords = $preview['meta_keywords'][$locale] ?? '';

        $cam->og_title = $preview['og_title'][$locale] ?? '';
        $cam->og_description = $preview['og_description'][$locale] ?? '';
        $cam->canonical_url = $preview['canonical_url'][$locale] ?? '';

        $cam->status = $preview['status'] ?? '0';
        $cam->start_date = $preview['start_date'] ?? null;
        $cam->end_date = $preview['end_date'] ?? null;

        // cover image fallback
        if (!empty($preview['__temp_cover_image'])) {
            $cam->cover_image_url = asset('storage/' . $preview['__temp_cover_image']);
        } elseif (!empty($preview['__existing_cover_image'])) {
            $cam->cover_image_url = asset('storage/cover_image/' . $preview['__existing_cover_image']);
        } else {
            $cam->cover_image_url = null;
        }

        // og image fallback
        if (!empty($preview['__temp_og_image'])) {
            $cam->og_image_url = asset('storage/' . $preview['__temp_og_image']);
        } elseif (!empty($preview['__existing_og_image'])) {
            $cam->og_image_url = asset('storage/og_image/' . $preview['__existing_og_image']);
        } else {
            $cam->og_image_url = null;
        }

        return view('admin.canpaign.minicampaign_front_preview', [
            'cam' => $cam,
            'preview' => $preview,
            'locale' => $locale,
        ]);
    }
}