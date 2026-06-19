<?php

namespace App\Filament\Concerns;

use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;

use function Filament\Support\original_request;

trait HasSingletonResourceUrls
{
    public static function getIndexUrl(
        array $parameters = [],
        bool $isAbsolute = true,
        ?string $panel = null,
        ?Model $tenant = null,
        bool $shouldGuessMissingParameters = false,
    ): string {
        return static::getUrl('edit', $parameters, $isAbsolute, $panel, $tenant, $shouldGuessMissingParameters);
    }

    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit');
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    /**
     * @return array<NavigationItem>
     */
    public static function getNavigationItems(): array
    {
        if (! static::hasPage('edit')) {
            return [];
        }

        $activeRoutePattern = static::getNavigationItemActiveRoutePattern();

        return [
            NavigationItem::make(static::getNavigationLabel())
                ->group(static::getNavigationGroup())
                ->parentItem(static::getNavigationParentItem())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(fn (): bool => original_request()->routeIs($activeRoutePattern))
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->badgeTooltip(static::getNavigationBadgeTooltip())
                ->sort(static::getNavigationSort())
                ->url(static::getNavigationUrl()),
        ];
    }
}
