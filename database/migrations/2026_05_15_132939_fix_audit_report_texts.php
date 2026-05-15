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
        // Fix DB settings table placeholders and typos
        $settings = \App\Models\WebsiteSetting::first();
        if ($settings) {
            $changed = false;

            // Helper to handle translated fields
            $updateTranslation = function($field, $search, $replace, $isRegex = false) use ($settings, &$changed) {
                $translations = $settings->getTranslations($field);
                if (empty($translations)) return;

                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    
                    if ($isRegex) {
                        $newText = preg_replace($search, $replace, $text);
                    } else {
                        $newText = str_replace($search, $replace, $text);
                    }

                    if ($newText !== $text) {
                        $settings->setTranslation($field, $locale, trim($newText));
                        $changed = true;
                    }
                }
            };

            // Fix Lorem Ipsum
            $updateTranslation('contact_us_content', '/Lorem ipsum.*/i', 'Reach out to us for more information', true);

            // Fix Email Domain
            $cryptoFields = ['donor_cripto_content_1', 'donor_cripto_content_2', 'how_to_donate_cripto'];
            foreach ($cryptoFields as $field) {
                $updateTranslation($field, 'donate@sai.org', 'donate@sai.ngo');
            }

            // Fix Truncated heading on Crypto Page
            $updateTranslation('donor_cripto_title_1', 'How to donate cryptocurrenc', 'How to donate cryptocurrency');
            $updateTranslation('donor_cripto_title_2', ['How to donate cryptocurrenc', 'infos'], ['How to donate cryptocurrency', 'information']);

            // Fix Columbia to Colombia in Employer Matching
            foreach (['emp_match_section_1', 'emp_match_section_2', 'emp_match_section_3', 'emp_match_section_4', 'emp_match_section_5', 'description', 'our_mission', 'urgent_help_description'] as $sf) {
                $updateTranslation($sf, 'Columbia', 'Colombia');
            }

            if ($changed) {
                $settings->save();
            }
        }

        // Fix typos in campaigns table
        $campaigns = \App\Models\Campaign::all();
        foreach ($campaigns as $campaign) {
            $campChanged = false;
            
            $updateCampTrans = function($field, $search, $replace) use ($campaign, &$campChanged) {
                $translations = $campaign->getTranslations($field);
                if (empty($translations)) return;

                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    
                    $newText = str_replace($search, $replace, $text);
                    if ($newText !== $text) {
                        $campaign->setTranslation($field, $locale, $newText);
                        $campChanged = true;
                    }
                }
            };

            $fields = ['donorbox_code', 'standard_webpage_content', 'problem', 'solution', 'impact', 'short_description', 'sub_title'];
            foreach ($fields as $field) {
                $updateCampTrans($field, 
                    ['commited', 'SAI are a 501(c)(3)', 'Columbia', 'its key old_campaigns'], 
                    ['committed', 'SAI is a 501(c)(3)', 'Colombia', '']
                );
                
                $updateCampTrans($field,
                    ['support for for three', '3 mealsclothing', 'for 2 month / 4 month / 6 month'],
                    ['support for three', '3 meals, clothing', 'for 2 months / 4 months / 6 months']
                );
            }

            if ($campChanged) {
                $campaign->save();
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
