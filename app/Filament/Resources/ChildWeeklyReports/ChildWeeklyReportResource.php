<?php

namespace App\Filament\Resources\ChildWeeklyReports;

use App\Filament\Resources\ChildWeeklyReports\Pages\CreateChildWeeklyReport;
use App\Filament\Resources\ChildWeeklyReports\Pages\EditChildWeeklyReport;
use App\Filament\Resources\ChildWeeklyReports\Pages\ListChildWeeklyReports;
use App\Filament\Resources\ChildWeeklyReports\Schemas\ChildWeeklyReportForm;
use App\Filament\Resources\ChildWeeklyReports\Tables\ChildWeeklyReportsTable;
use App\Models\ChildWeeklyReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ChildWeeklyReportResource extends Resource
{
    protected static ?string $model = ChildWeeklyReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Weekly Reports';

    protected static ?string $modelLabel = 'Weekly Report';

    protected static ?int $navigationSort = 13;

    public static function getNavigationGroup(): ?string
    {
        return 'Reports';
    }

    public static function form(Schema $schema): Schema
    {
        return ChildWeeklyReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChildWeeklyReportsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['child', 'parent']);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChildWeeklyReports::route('/'),
            'create' => CreateChildWeeklyReport::route('/create'),
            'edit' => EditChildWeeklyReport::route('/{record}/edit'),
        ];
    }
}
