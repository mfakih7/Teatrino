<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Throwable;

class SystemSettings extends Page
{
    use CanUseDatabaseTransactions;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $navigationLabel = 'System Settings';

    protected static ?int $navigationSort = 100;

    protected static ?string $title = 'System Settings';

    protected static ?string $slug = 'system-settings';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public function mount(): void
    {
        $settings = SiteSetting::instance();
        $user = Auth::user();

        $this->form->fill([
            'admin_email' => $user?->email,
            'admin_password' => null,
            'admin_password_confirmation' => null,
            'logo_path' => $settings->logo_path,
            'favicon_path' => $settings->favicon_path,
            'whatsapp_number' => $settings->whatsapp_number,
            'whatsapp_message' => $settings->whatsapp_message,
            'social_facebook' => $settings->social_facebook,
            'social_instagram' => $settings->social_instagram,
            'social_tiktok' => $settings->social_tiktok,
            'social_youtube' => $settings->social_youtube,
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Admin Account')->schema([
                TextInput::make('admin_email')
                    ->label('Admin Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class, 'email', ignorable: fn () => Auth::user()),
                TextInput::make('admin_password')
                    ->label('New Password')
                    ->password()
                    ->revealable()
                    ->rule(Password::defaults())
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->nullable()
                    ->helperText('Leave blank to keep the current password.'),
                TextInput::make('admin_password_confirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->revealable()
                    ->same('admin_password')
                    ->dehydrated(false)
                    ->nullable(),
            ])->columns(2),
            Section::make('Branding')->schema([
                FileUpload::make('logo_path')
                    ->label('Website Logo')
                    ->image()
                    ->disk('public')
                    ->directory('branding')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->nullable()
                    ->helperText('Shown in the site header and admin panel when set.'),
                FileUpload::make('favicon_path')
                    ->label('Favicon')
                    ->image()
                    ->disk('public')
                    ->directory('branding')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                    ->maxSize(1024)
                    ->nullable()
                    ->helperText('Browser tab icon. Square PNG, JPG, WebP, or SVG recommended.'),
            ])->columns(2),
            Section::make('Contact & Social')->schema([
                TextInput::make('whatsapp_number')
                    ->label('WhatsApp Number')
                    ->maxLength(32)
                    ->helperText('International format without +, e.g. 96170123456'),
                Textarea::make('whatsapp_message')
                    ->label('Default WhatsApp Message')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('social_facebook')->label('Facebook')->url()->maxLength(255),
                TextInput::make('social_instagram')->label('Instagram')->url()->maxLength(255),
                TextInput::make('social_tiktok')->label('TikTok')->url()->maxLength(255),
                TextInput::make('social_youtube')->label('YouTube')->url()->maxLength(255),
            ])->columns(2),
        ]);
    }

    public function save(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $data = $this->form->getState();

            $user = Auth::user();

            if ($user) {
                $userData = ['email' => $data['admin_email']];

                if (! empty($data['admin_password'])) {
                    $userData['password'] = $data['admin_password'];
                }

                $user->update($userData);
            }

            SiteSetting::instance()->update([
                'logo_path' => $data['logo_path'] ?? null,
                'favicon_path' => $data['favicon_path'] ?? null,
                'whatsapp_number' => $data['whatsapp_number'] ?? null,
                'whatsapp_message' => $data['whatsapp_message'] ?? null,
                'social_facebook' => $data['social_facebook'] ?? null,
                'social_instagram' => $data['social_instagram'] ?? null,
                'social_tiktok' => $data['social_tiktok'] ?? null,
                'social_youtube' => $data['social_youtube'] ?? null,
            ]);

            $this->commitDatabaseTransaction();
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction()
                ? $this->rollBackDatabaseTransaction()
                : $this->commitDatabaseTransaction();

            return;
        } catch (Throwable $exception) {
            $this->rollBackDatabaseTransaction();

            throw $exception;
        }

        Notification::make()
            ->title('System settings saved')
            ->success()
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('Save settings')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ]),
                ]),
        ]);
    }
}
