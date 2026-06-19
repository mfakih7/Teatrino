<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addIndex('users', 'is_admin', 'users_is_admin_idx');

        $this->addIndex('articles', 'published_at', 'articles_published_at_idx');
        $this->addIndex('articles', 'is_active', 'articles_is_active_idx');
        $this->addIndex('articles', ['is_active', 'published_at'], 'articles_active_published_idx');

        $this->addIndex('portfolio_items', ['is_active', 'sort_order'], 'portfolio_active_sort_idx');
        $this->addIndex('portfolio_items', 'sort_order', 'portfolio_sort_order_idx');

        $this->addIndex('home_feature_cards', ['is_active', 'sort_order'], 'feature_cards_active_sort_idx');

        $this->addIndex('about_pages', 'is_active', 'about_pages_is_active_idx');

        $this->addIndex('parents', 'whatsapp_number', 'parents_whatsapp_idx');

        $this->addIndex('child_payments', ['year', 'month'], 'payments_year_month_idx');
        $this->addIndex('child_payments', 'due_date', 'payments_due_date_idx');
        $this->addIndex('child_payments', 'paid_at', 'payments_paid_at_idx');

        $this->addIndex('child_weekly_reports', 'created_at', 'weekly_reports_created_at_idx');

        $this->addIndex(
            'media',
            ['mediable_type', 'mediable_id', 'collection', 'sort_order'],
            'media_morph_collection_sort_idx'
        );

        $this->addIndex('cache', 'expiration', 'cache_expiration_idx');
    }

    public function down(): void
    {
        $this->dropIndex('cache', 'cache_expiration_idx');

        $this->dropIndex('media', 'media_morph_collection_sort_idx');

        $this->dropIndex('child_weekly_reports', 'weekly_reports_created_at_idx');

        $this->dropIndex('child_payments', 'payments_paid_at_idx');
        $this->dropIndex('child_payments', 'payments_due_date_idx');
        $this->dropIndex('child_payments', 'payments_year_month_idx');

        $this->dropIndex('parents', 'parents_whatsapp_idx');

        $this->dropIndex('about_pages', 'about_pages_is_active_idx');

        $this->dropIndex('home_feature_cards', 'feature_cards_active_sort_idx');

        $this->dropIndex('portfolio_items', 'portfolio_sort_order_idx');
        $this->dropIndex('portfolio_items', 'portfolio_active_sort_idx');

        $this->dropIndex('articles', 'articles_active_published_idx');
        $this->dropIndex('articles', 'articles_is_active_idx');
        $this->dropIndex('articles', 'articles_published_at_idx');

        $this->dropIndex('users', 'users_is_admin_idx');
    }

    /**
     * @param  array<int, string>|string  $columns
     */
    private function addIndex(string $table, array|string $columns, string $name): void
    {
        if ($this->hasIndex($table, $name)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($columns, $name): void {
            $blueprint->index($columns, $name);
        });
    }

    private function dropIndex(string $table, string $name): void
    {
        if (! $this->hasIndex($table, $name)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($name): void {
            $blueprint->dropIndex($name);
        });
    }

    private function hasIndex(string $table, string $name): bool
    {
        return collect(Schema::getIndexes($table))
            ->contains(fn (array $index): bool => ($index['name'] ?? null) === $name);
    }
};
