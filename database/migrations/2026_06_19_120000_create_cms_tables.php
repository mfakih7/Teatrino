<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name_en')->nullable();
            $table->string('website_name_ar')->nullable();
            $table->string('website_name_fr')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->text('whatsapp_message')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->text('footer_text_en')->nullable();
            $table->text('footer_text_ar')->nullable();
            $table->text('footer_text_fr')->nullable();
            $table->string('contact_title_en')->nullable();
            $table->string('contact_title_ar')->nullable();
            $table->string('contact_title_fr')->nullable();
            $table->text('contact_description_en')->nullable();
            $table->text('contact_description_ar')->nullable();
            $table->text('contact_description_fr')->nullable();
            $table->timestamps();
        });

        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title_en')->nullable();
            $table->string('hero_title_ar')->nullable();
            $table->string('hero_title_fr')->nullable();
            $table->string('hero_subtitle_en')->nullable();
            $table->string('hero_subtitle_ar')->nullable();
            $table->string('hero_subtitle_fr')->nullable();
            $table->text('hero_description_en')->nullable();
            $table->text('hero_description_ar')->nullable();
            $table->text('hero_description_fr')->nullable();
            $table->string('cta_portfolio_en')->nullable();
            $table->string('cta_portfolio_ar')->nullable();
            $table->string('cta_portfolio_fr')->nullable();
            $table->string('cta_whatsapp_en')->nullable();
            $table->string('cta_whatsapp_ar')->nullable();
            $table->string('cta_whatsapp_fr')->nullable();
            $table->string('welcome_heading_en')->nullable();
            $table->string('welcome_heading_ar')->nullable();
            $table->string('welcome_heading_fr')->nullable();
            $table->string('explore_heading_en')->nullable();
            $table->string('explore_heading_ar')->nullable();
            $table->string('explore_heading_fr')->nullable();
            $table->text('explore_text_en')->nullable();
            $table->text('explore_text_ar')->nullable();
            $table->text('explore_text_fr')->nullable();
            $table->timestamps();
        });

        Schema::create('home_feature_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->string('icon', 16)->default('🎨');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_fr')->nullable();
            $table->longText('body_en')->nullable();
            $table->longText('body_ar')->nullable();
            $table->longText('body_fr')->nullable();
            $table->text('mission_en')->nullable();
            $table->text('mission_ar')->nullable();
            $table->text('mission_fr')->nullable();
            $table->text('vision_en')->nullable();
            $table->text('vision_ar')->nullable();
            $table->text('vision_fr')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_fr')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_ar')->nullable();
            $table->text('excerpt_fr')->nullable();
            $table->longText('body_en')->nullable();
            $table->longText('body_ar')->nullable();
            $table->longText('body_fr')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('portfolio_items');
        Schema::dropIfExists('about_pages');
        Schema::dropIfExists('home_feature_cards');
        Schema::dropIfExists('home_contents');
        Schema::dropIfExists('site_settings');
    }
};
