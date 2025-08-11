<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KuotaResource\Pages;
use App\Filament\Resources\KuotaResource\RelationManagers;
use App\Models\Kuota;
use App\Models\MKuotaTabs;
use Filament\Actions\StaticAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KuotaResource extends Resource
{
    protected static ?string $model = MKuotaTabs::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Kuota Pendaki';
    protected static ?string $breadcrumb = "Kuota";
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
            TextInput::make('kuota')->label('Kuota Mendaki')->placeholder('Kuota Mendaki')->required(),
            DatePicker::make('start_dates')->label('Start Date')
                ->placeholder('Pilih Waktu')
                ->firstDayOfWeek(7)->seconds(false)
                ->closeOnDateSelection()->required(),
            DatePicker::make('end_dates')->label('End Date')
                ->placeholder('Pilih Waktu')
                ->firstDayOfWeek(7)->seconds(false)
                ->closeOnDateSelection()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kuota')->label('Kuota Mendaki'),
            TextColumn::make('start_dates')->label('Start Date')->date(),
            TextColumn::make('end_dates')->label('Start End')->date(),
                TextColumn::make('m_status_tabs_id')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    'DRAFT' => 'draft',
                    'PUBLISH' => 'success',
                    'UNPUBLISH' => 'danger',
                })->getStateUsing(fn($record) => $record->status ? $record->status->title : 'Tidak Ada')
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->visible(fn($record) => $record->m_status_tabs_id === 1),
                    Action::make('published')
                        ->label('Publish')
                        ->action(function ($record) {
                            $record->update([
                                'm_status_tabs_id' => 2,
                            ]);
                        })
                        ->visible(fn($record) => ($record->m_status_tabs_id === 1 || $record->m_status_tabs_id === 3))
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Publish Kuota Pendakian')
                        ->modalDescription('Apakah anda yakin ingin Publish Kuota Pendakian ?')
                        ->modalSubmitActionLabel('Publish Sekarang')
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')),
                    Action::make('unpublished')
                        ->label('Un-Publish')
                        ->action(function ($record) {
                            $record->update([
                                'm_status_tabs_id' => 3,
                            ]);
                        })
                        ->visible(fn($record) => $record->m_status_tabs_id === 2)
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Un-Publish Kuota Pendakian')
                        ->modalDescription('Apakah anda yakin ingin Un-Publish Kuota Pendakian ?')
                        ->modalSubmitActionLabel('Un-Publish Sekarang')
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')),
                ])
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
            'index' => Pages\ListKuotas::route('/'),
            'create' => Pages\CreateKuota::route('/create'),
            'edit' => Pages\EditKuota::route('/{record}/edit'),
        ];
    }
}
