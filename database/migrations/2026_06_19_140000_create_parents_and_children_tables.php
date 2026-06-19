<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('whatsapp_number')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('full_name');
            $table->index('phone_number');
            $table->index('is_active');
        });

        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('class_name')->nullable();
            $table->text('allergies')->nullable();
            $table->text('health_notes')->nullable();
            $table->text('special_notes')->nullable();
            $table->string('profile_photo_original_path')->nullable();
            $table->string('profile_photo_thumbnail_path')->nullable();
            $table->string('profile_photo_optimized_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('full_name');
            $table->index('class_name');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
        Schema::dropIfExists('parents');
    }
};
