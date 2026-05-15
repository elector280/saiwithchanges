<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = DB::table('website_settings')->first();
        if ($settings) {
            $updates = [];

            // Fix Lorem Ipsum placeholder in Contact Us Content
            if (!empty($settings->contact_us_content) && stripos($settings->contact_us_content, 'Lorem ipsum') !== false) {
                // Completely remove lorem ipsum text or empty it if it's the only text
                $newContent = preg_replace('/Lorem ipsum.*/i', '', $settings->contact_us_content);
                $updates['contact_us_content'] = trim($newContent);
            }

            // Fix Wrong Email Domain on Crypto page
            if (!empty($settings->donor_cripto_content_1)) {
                $updates['donor_cripto_content_1'] = str_replace('donate@sai.org', 'donate@sai.ngo', $settings->donor_cripto_content_1);
            }
            if (!empty($settings->donor_cripto_content_2)) {
                $updates['donor_cripto_content_2'] = str_replace('donate@sai.org', 'donate@sai.ngo', $settings->donor_cripto_content_2);
            }

            // Fix Truncated heading on Crypto Page
            if (!empty($settings->donor_cripto_title_1)) {
                $updates['donor_cripto_title_1'] = str_replace('How to donate cryptocurrenc', 'How to donate cryptocurrency', $settings->donor_cripto_title_1);
            }
            if (!empty($settings->donor_cripto_title_2)) {
                $updates['donor_cripto_title_2'] = str_replace(['How to donate cryptocurrenc', 'infos'], ['How to donate cryptocurrency', 'information'], $settings->donor_cripto_title_2);
            }

            // Fix Columbia to Colombia in Employer Matching
            foreach (['double_donation_content', 'double_donation_title', 'description', 'our_mission', 'urgent_help_description'] as $sf) {
                if (!empty($settings->$sf)) {
                    $updates[$sf] = str_replace('Columbia', 'Colombia', $updates[$sf] ?? $settings->$sf);
                }
            }

            if (!empty($updates)) {
                DB::table('website_settings')->update($updates);
            }
        }

        // Fix typos in campaigns table
        $campaigns = DB::table('campaigns')->get();
        foreach ($campaigns as $campaign) {
            $campUpdates = [];
            
            $fields = ['donorbox_code', 'standard_webpage_content', 'description', 'problem', 'solution', 'impact', 'short_description', 'sub_title'];
            foreach ($fields as $field) {
                if (!empty($campaign->$field)) {
                    $newText = str_replace(
                        ['commited', 'SAI are a 501(c)(3)', 'Columbia', 'its key old_campaigns'], 
                        ['committed', 'SAI is a 501(c)(3)', 'Colombia', ''], 
                        $campaign->$field
                    );
                    
                    // Also fix orphans typo and old_campaigns if they appear here
                    $newText = str_replace(
                        ['support for for three', '3 mealsclothing', 'for 2 month / 4 month / 6 month'],
                        ['support for three', '3 meals, clothing', 'for 2 months / 4 months / 6 months'],
                        $newText
                    );
                    
                    if ($newText !== $campaign->$field) {
                        $campUpdates[$field] = $newText;
                    }
                }
            }

            if (!empty($campUpdates)) {
                DB::table('campaigns')->where('id', $campaign->id)->update($campUpdates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 
    }
};
