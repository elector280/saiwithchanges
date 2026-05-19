<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\WebsiteSetting;
use App\Models\Campaign;
use App\Models\MiniCampaignTemplate;
use App\Models\Category;
use App\Models\Review;
use App\Models\Story;
use App\Models\Sponsor;
use App\Models\LanguageTranslation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update Website Settings
        $settings = WebsiteSetting::first();
        if ($settings) {
            // Helper to handle translated fields
            $updateSettingTrans = function($field, $search, $replace) use ($settings) {
                $translations = $settings->getTranslations($field);
                if (empty($translations)) return;
                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    $newText = str_replace($search, $replace, $text);
                    if ($newText !== $text) {
                        $settings->setTranslation($field, $locale, trim($newText));
                    }
                }
            };

            // G-01: Crypto Heading
            $updateSettingTrans('donor_cripto_title_1', 'How to donate <br> cryptocurrenc', 'How to donate <br> cryptocurrency');
            $updateSettingTrans('donor_cripto_title_2', 'How to donate <br> cryptocurrenc', 'How to donate <br> cryptocurrency');

            // G-02: Contact Us intro (strip Latin trailing placeholder)
            $settings->setTranslation('contact_us_content', 'en', 'Reach out to us for more information. We are here to help and answer any questions you might have. We look forward to hearing from you.');
            $settings->setTranslation('contact_us_content', 'es', 'Póngase en contacto con nosotros para obtener más información. Estamos aquí para ayudar y responder a cualquier pregunta que pueda tener. Esperamos saber de usted.');

            // G-05: Review Subtitle
            $settings->setTranslation('review_sub_title', 'en', 'REVIEWS FROM PEOPLE WE <br> HELPED THANKS TO YOU');
            $settings->setTranslation('review_sub_title', 'es', 'TESTIMONIOS DE LAS PERSONAS QUE AYUDAMOS GRACIAS A TI');

            // G-14: Office address
            $settings->address = '8211 W Broward Blvd Ste 410, Plantation, FL 33324, USA';
            $settings->office_usa = '8211 W Broward Blvd Ste 410, Plantation, FL 33324, USA';

            // G-15: Phone format & general sweep for nonprofit and double hyphens
            $settings->office_venezuela = "Valencia, Venezuela\r\nTel: (800) 563-6099\r\nEmail: donate@sai.ngo";

            // Sweep settings translations for nonprofit -> nonprofit, and -- / ─ -> —
            $settingTextCols = [
                'description', 'our_mission', 'about_us_content_home', 'donor_cripto_content_1',
                'donor_cripto_content_2', 'how_to_donate_cripto', 'emp_match_section_1',
                'emp_match_section_2', 'emp_match_section_3', 'emp_match_section_4', 'emp_match_section_5'
            ];
            foreach ($settingTextCols as $col) {
                $translations = $settings->getTranslations($col);
                if (empty($translations)) continue;
                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    $newText = str_replace(
                        ['non-profit', 'Non-profit', 'NON-PROFIT', ' -- ', ' ─ '],
                        ['nonprofit', 'Nonprofit', 'NONPROFIT', ' — ', ' — '],
                        $text
                    );
                    if ($newText !== $text) {
                        $settings->setTranslation($col, $locale, $newText);
                    }
                }
            }

            $settings->save();
        }

        // 2. Update Campaigns
        $campaigns = Campaign::all();
        foreach ($campaigns as $campaign) {
            $changed = false;

            $updateCampTrans = function($field, $search, $replace) use ($campaign, &$changed) {
                $translations = $campaign->getTranslations($field);
                if (empty($translations)) return;
                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    $newText = str_replace($search, $replace, $text);
                    if ($newText !== $text) {
                        $campaign->setTranslation($field, $locale, $newText);
                        $changed = true;
                    }
                }
            };

            // Apply G-08 tax-deductible correction (hyphenated when adjectival)
            // G-15 general style guide: non-profit -> nonprofit, double hyphen -> em dash
            // Note: only include attributes registered as translatable in Campaign.php
            $textFields = [
                'title', 'sub_title', 'summary', 'standard_webpage_content', 'problem', 'solution',
                'impact', 'google_description', 'short_description', 'donorbox_code', 'video',
                'seo_title', 'seo_description', 'meta_keyword', 'slug', 'footer_title', 'footer_subtitle', 'path'
            ];
            foreach ($textFields as $field) {
                $updateCampTrans($field,
                    ['tax deductible', 'Tax deductible', 'TAX DEDUCTIBLE', 'non-profit', 'Non-profit', 'NON-PROFIT', ' -- ', ' ─ '],
                    ['tax-deductible', 'Tax-deductible', 'TAX-DEDUCTIBLE', 'nonprofit', 'Nonprofit', 'NONPROFIT', ' — ', ' — ']
                );
            }

            // G-06: Pets Campaign ID 18 - "neuteured/spayed" -> "neutered/spayed"
            if ($campaign->id == 18) {
                $updateCampTrans('standard_webpage_content', 'neuteured', 'neutered');
                $updateCampTrans('solution', 'neuteured', 'neutered');
            }

            // G-07: Orphans Campaign ID 7 and Refugees Campaign ID 10
            if ($campaign->id == 7 || $campaign->id == 10) {
                $updateCampTrans('standard_webpage_content', 'South American Initiative are a 501(c)(3)', 'South American Initiative is a 501(c)(3)');
            }

            // G-11: Neurosurgery Campaign ID 12
            if ($campaign->id == 12) {
                $updateCampTrans('short_description', 'kids suffering form epilepsy', 'kids suffering from epilepsy');
                $updateCampTrans('summary', 'kids suffering form epilepsy', 'kids suffering from epilepsy');
                $updateCampTrans('problem', 'epilepsy result in 1-2', 'epilepsy results in 1–2');
            }

            // G-12: Hospitals Campaign ID 17
            if ($campaign->id == 17) {
                $updateCampTrans('standard_webpage_content', 'hospitals Venezuela, and are not being well fed.', 'hospitals in Venezuela who are not being well fed.');
            }

            // G-13: Help Venezuela Campaign ID 2
            if ($campaign->id == 2) {
                $updateCampTrans('standard_webpage_content', 'Essential Medications are hard', 'Essential medications are hard');
                $updateCampTrans('standard_webpage_content', 'bring their own Medication', 'bring their own medication');
                $updateCampTrans('standard_webpage_content', 'shortages of essential Medication', 'shortages of medication');
                $updateCampTrans('standard_webpage_content', 'children; It can’t be done.', 'children — it can’t be done.');
            }

            // G-15: Restore Spanish accents for Orphans Campaign ID 7
            if ($campaign->id == 7) {
                $updateCampTrans('standard_webpage_content', 'Maria Auxiliadora', 'María Auxiliadora');
                $updateCampTrans('standard_webpage_content', 'Inmaculado Corazon de Maria', 'Inmaculado Corazón de María');
            }

            if ($changed) {
                $campaign->save();
            }
        }

        // 3. Update Stories and Sponsors
        $stories = Story::all();
        foreach ($stories as $story) {
            $changed = false;
            $storyFields = ['title', 'short_description', 'description', 'seo_title', 'tags', 'meta_description', 'slug', 'footer_title', 'footer_subtitle', 'reportpath'];
            foreach ($storyFields as $field) {
                $translations = $story->getTranslations($field);
                if (empty($translations)) continue;
                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    $newText = str_replace(
                        ['non-profit', 'Non-profit', 'NON-PROFIT', ' -- ', ' ─ '],
                        ['nonprofit', 'Nonprofit', 'NONPROFIT', ' — ', ' — '],
                        $text
                    );
                    if ($newText !== $text) {
                        $story->setTranslation($field, $locale, $newText);
                        $changed = true;
                    }
                }
            }
            if ($changed) {
                $story->save();
            }
        }

        $sponsors = Sponsor::all();
        foreach ($sponsors as $sponsor) {
            $changed = false;
            $sponsorFields = ['company_name', 'sub_title', 'content'];
            foreach ($sponsorFields as $field) {
                $translations = $sponsor->getTranslations($field);
                if (empty($translations)) continue;
                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    $newText = str_replace(
                        ['non-profit', 'Non-profit', 'NON-PROFIT', ' -- ', ' ─ '],
                        ['nonprofit', 'Nonprofit', 'NONPROFIT', ' — ', ' — '],
                        $text
                    );
                    if ($newText !== $text) {
                        $sponsor->setTranslation($field, $locale, $newText);
                        $changed = true;
                    }
                }
            }
            if ($changed) {
                $sponsor->save();
            }
        }

        // 4. Update Mini Campaign Templates
        $miniTemplate = MiniCampaignTemplate::find(3);
        if ($miniTemplate) {
            // G-03: Unique body copy & meta SEO settings in both languages
            
            // Short description
            $miniTemplate->setTranslation('short_description', 'en', 'Our humanitarian medical clinic in Venezuela provides urgent healthcare, pediatric support, vital medications, and nutritional aid to children and vulnerable families in crisis.');
            $miniTemplate->setTranslation('short_description', 'es', 'Nuestra clínica médica humanitaria en Venezuela brinda atención médica urgente, apoyo pediátrico, medicamentos vitales y ayuda nutricional a niños y familias vulnerables en crisis.');

            // Paragraph One
            $miniTemplate->setTranslation('paragraph_one', 'en', '<p>The ongoing crisis in Venezuela has devastated the healthcare system, leaving hospitals without basic supplies and families unable to afford essential treatments. Our dedicated medical clinic is on the ground, offering pediatric checkups, life-saving medications, and specialized consultations to those in desperate need.</p>');
            $miniTemplate->setTranslation('paragraph_one', 'es', '<p>La crisis actual en Venezuela ha devastado el sistema de salud, dejando a los hospitales sin suministros básicos y a las familias sin poder costear tratamientos esenciales. Nuestra clínica médica está en el terreno, ofreciendo chequeos pediátricos, medicamentos vitales y consultas especializadas a quienes más lo necesitan.</p>');

            // Paragraph Two
            $miniTemplate->setTranslation('paragraph_two', 'en', '<p>By supporting this program, you directly fund medical services, vitamins, baby formula, and therapeutic food for malnourished children. Your generous contribution helps us sustain these critical operations and save young lives every single day. Donate now to make a difference.</p>');
            $miniTemplate->setTranslation('paragraph_two', 'es', '<p>Al apoyar este programa, financias directamente servicios médicos, vitaminas, fórmula para bebés y alimentos terapéuticos para niños desnutridos. Tu generosa contribución nos ayuda a sostener estas operaciones críticas y salvar vidas jóvenes todos los días. Dona ahora para marcar la diferencia.</p>');

            // Meta Title
            $miniTemplate->setTranslation('meta_title', 'en', 'Provide Food and Medical Care in Venezuela | South American Initiative');
            $miniTemplate->setTranslation('meta_title', 'es', 'Brinda Alimentos y Atención Médica en Venezuela | South American Initiative');

            // Meta Description
            $miniTemplate->setTranslation('meta_description', 'en', 'Help South American Initiative provide urgent medical care, pediatric support, and nutritional aid to children and families in Venezuela.');
            $miniTemplate->setTranslation('meta_description', 'es', 'Ayuda a South American Initiative a brindar atención médica urgente, apoyo pediátrico y ayuda nutricional a niños y familias en Venezuela.');

            // Meta Keywords
            $miniTemplate->setTranslation('meta_keywords', 'en', 'medical care venezuela, clinic patients, pediatric support venezuela, humanitarian aid, healthcare crisis, donate to venezuela, south american initiative');
            $miniTemplate->setTranslation('meta_keywords', 'es', 'atencion medica venezuela, pacientes clinica, apoyo pediatrico venezuela, ayuda humanitaria, crisis de salud, donar a venezuela, south american initiative');

            // OG Title
            $miniTemplate->setTranslation('og_title', 'en', 'Provide Food and Medical Care in Venezuela | South American Initiative');
            $miniTemplate->setTranslation('og_title', 'es', 'Brinda Alimentos y Atención Médica en Venezuela | South American Initiative');

            // OG Description
            $miniTemplate->setTranslation('og_description', 'en', 'Help South American Initiative provide urgent medical care, pediatric support, and nutritional aid to children and families in Venezuela.');
            $miniTemplate->setTranslation('og_description', 'es', 'Ayuda a South American Initiative a brindar atención médica urgente, apoyo pediátrico y ayuda nutricional a niños y familias en Venezuela.');

            $miniTemplate->save();
        }

        // 5. Update Categories
        // G-04: Topic filter pill misspelled: "Refugess" -> "Refugees"
        $category = Category::find(19);
        if ($category) {
            $category->name = 'Refugees';
            $category->slug = 'refugees';
            $category->save();
        }

        // 6. Update Reviews
        // G-05: Typos in reviews: "I to have" -> "I too have"
        $reviews = Review::whereIn('id', [1, 2])->get();
        foreach ($reviews as $review) {
            $translations = $review->getTranslations('description');
            if (!empty($translations)) {
                foreach ($translations as $locale => $text) {
                    if (empty($text)) continue;
                    $newText = str_replace('I to have received', 'I too have received', $text);
                    if ($newText !== $text) {
                        $review->setTranslation('description', $locale, $newText);
                    }
                }
                $review->save();
            }
        }

        // 7. Insert new translations keys
        $translationsToInsert = [
            [
                'lang_key' => 'become_sponsor',
                'translations' => [
                    'en' => 'Become a Sponsor',
                    'es' => 'Conviértete en Patrocinador'
                ]
            ],
            [
                'lang_key' => 'become_a_sponsor',
                'translations' => [
                    'en' => 'Become a Sponsor',
                    'es' => 'Conviértete en Patrocinador'
                ]
            ],
            [
                'lang_key' => 'donate_to_this_project',
                'translations' => [
                    'en' => 'Donate to this Project',
                    'es' => 'Dona a este Proyecto'
                ]
            ],
            [
                'lang_key' => 'help_support_this_project',
                'translations' => [
                    'en' => 'Help Support This Project',
                    'es' => 'Apoya este Proyecto'
                ]
            ]
        ];

        foreach ($translationsToInsert as $trans) {
            foreach ($trans['translations'] as $lang => $val) {
                $t = LanguageTranslation::where('lang', $lang)->where('lang_key', $trans['lang_key'])->first();
                if (!$t) {
                    $t = new LanguageTranslation();
                    $t->lang = $lang;
                    $t->lang_key = $trans['lang_key'];
                }
                $t->lang_value = $val;
                $t->save();
            }
        }

        // Forget translation cache
        \Illuminate\Support\Facades\Cache::forget('translations-en');
        \Illuminate\Support\Facades\Cache::forget('translations-es');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Not needed for this QA fix migration
    }
};
