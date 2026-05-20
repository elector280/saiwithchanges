<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('about_us_cover_image_home_layout')->nullable()->default('object-cover object-center')->after('about_us_cover_image_home');
            $table->string('help_people_need_image_layout')->nullable()->default('object-cover object-center')->after('help_people_need_image');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('hero_image_layout')->nullable()->default('object-cover object-center')->after('hero_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['about_us_cover_image_home_layout', 'help_people_need_image_layout']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('hero_image_layout');
        });
    }
};
