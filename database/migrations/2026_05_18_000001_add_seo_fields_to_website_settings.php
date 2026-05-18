<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->text('seo_title_about')->nullable()->after('about_us_title');
            $table->text('seo_description_about')->nullable()->after('seo_title_about');
            $table->text('seo_title_contact')->nullable()->after('contact_us_content');
            $table->text('seo_description_contact')->nullable()->after('seo_title_contact');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title_about',
                'seo_description_about',
                'seo_title_contact',
                'seo_description_contact',
            ]);
        });
    }
};
