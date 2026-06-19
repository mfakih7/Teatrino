<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->cascadeOnDelete();
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->string('eating_status')->nullable();
            $table->string('sleeping_status')->nullable();
            $table->string('learning_status')->nullable();
            $table->string('playing_status')->nullable();
            $table->string('behavior_status')->nullable();
            $table->string('mood_status')->nullable();
            $table->text('teacher_notes')->nullable();
            $table->text('health_notes')->nullable();
            $table->text('activities_summary')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('pdf_path')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['child_id', 'week_start_date', 'week_end_date'], 'weekly_reports_child_period_unique');
            $table->index(['week_start_date', 'week_end_date']);
            $table->index('parent_id');
            $table->index('sent_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_weekly_reports');
    }
};
