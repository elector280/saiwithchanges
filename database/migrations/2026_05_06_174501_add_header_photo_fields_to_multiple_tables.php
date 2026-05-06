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
        Schema::table('stories', function (Blueprint $table) {
            $table->string('header_photo')->nullable();
            $table->string('header_photo_layout')->nullable()->default('object-cover object-center');
        });
        
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('header_photo')->nullable();
            $table->string('header_photo_layout')->nullable()->default('object-cover object-center');
        });
        
        Schema::table('mini_campaign_templates', function (Blueprint $table) {
            $table->string('header_photo')->nullable();
            $table->string('header_photo_layout')->nullable()->default('object-cover object-center');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['header_photo', 'header_photo_layout']);
        });
        
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['header_photo', 'header_photo_layout']);
        });
        
        Schema::table('mini_campaign_templates', function (Blueprint $table) {
            $table->dropColumn(['header_photo', 'header_photo_layout']);
        });
    }
};
