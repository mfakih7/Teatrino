<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('position_en')->nullable();
            $table->string('position_ar')->nullable();
            $table->string('position_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('education_en')->nullable();
            $table->text('education_ar')->nullable();
            $table->text('education_fr')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order'], 'teachers_active_sort_idx');
            $table->index('sort_order', 'teachers_sort_order_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
