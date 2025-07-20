<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaResource\Pages;
use App\Filament\Resources\PenggunaResource\RelationManagers;
use App\Models\Admin;
use App\Models\MUserRoleTabs;
use App\Models\Pengguna;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class PenggunaResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $breadcrumb = "Pengguna";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->guard('admin')->user()->m_user_role_tabs_id == 1) return true;
        else return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('fullname')->label('Nama')->placeholder('Masukan Nama Pengguna')->required(),
            TextInput::make('email')->label('Email')->required(),
            Select::make('m_user_role_tabs_id')
                ->label('Pilih Role')
                ->relationship('role', 'title')
                ->placeholder('Cari Role')
                ->options(MUserRoleTabs::pluck('title', 'id'))
                ->getSearchResultsUsing(fn(string $search): array => MUserRoleTabs::where('title', 'like', "%{$search}%")->limit(5)->pluck('title', 'id')->toArray())
                ->getOptionLabelUsing(fn($value): ?string => MUserRoleTabs::find($value)?->title)
                ->required(),
            TextInput::make('password')->label('Password Akun')
                ->password()->revealable()
                ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                ->same('passwordConfirmation')
                ->placeholder('Masukan Password')
                ->dehydrated(fn(?string $state): bool => filled($state))
                ->required()
                ->afterStateHydrated(function (TextInput $component, $state) {
                    $component->state('');
                }),
            TextInput::make('passwordConfirmation')->label('Confirmasi Password Akun')->password()->revealable()->placeholder('Masukan Password')->required(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(
            Admin::whereNot('id', auth()->guard('admin')->user()->id)
        )
            ->columns([
            TextColumn::make('fullname')->label('Nama Pengguna'),
            TextColumn::make('email')->label('Email'),
            TextColumn::make('m_user_role_tabs_id')->label('Role')->getStateUsing(fn($record) => $record->role ? $record->role->title : 'Tidak Ada'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenggunas::route('/'),
            'create' => Pages\CreatePengguna::route('/create'),
            'edit' => Pages\EditPengguna::route('/{record}/edit'),
        ];
    }
}
