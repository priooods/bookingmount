<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PanduanResource\Pages;
use App\Models\TPanduanTab;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PanduanResource extends Resource
{
    protected static ?string $model = TPanduanTab::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Panduan';
    protected static ?string $breadcrumb = "Panduan";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('filename')->label('Nama File')->placeholder('Masukan nama panduan')->required(),
                FileUpload::make('file_path')->label('Pilih File Panduan')
                    ->uploadingMessage('Uploading attachment...')
                    ->acceptedFileTypes(['application/pdf'])
                    ->preserveFilenames()
                    ->directory('form-panduan')
                    ->maxSize(5000)->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('filename')->label('Nama File'),
                TextColumn::make('m_status_tabs')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    'DRAFT' => 'gray',
                    'PUBLISH' => 'success',
                    'UNPUBLISH' => 'danger',
                    'APPROVED' => 'success',
                    'CANCELLED' => 'danger',
                    'ON PROSES' => 'info',
                })->getStateUsing(fn($record) => $record->status ? $record->status->title : 'Tidak Ada')
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->visible(fn($record) => $record->m_status_tabs === 1),
                    Action::make('published')
                        ->label('Publish')
                        ->action(function ($record) {
                            $record->update([ 
                                'm_status_tabs' => 2,
                            ]);
                        })
                        ->visible(fn($record) => ($record->m_status_tabs === 1 || $record->m_status_tabs === 3))
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Publish Panduan Pendakian')
                        ->modalDescription('Apakah anda yakin ingin Publish Panduan Pendakian ?')
                        ->modalSubmitActionLabel('Publish Sekarang')
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')),
                    Action::make('unpublished')
                        ->label('Un-Publish')
                        ->action(function ($record) {
                            $record->update([
                                'm_status_tabs' => 3,
                            ]);
                        })
                        ->visible(fn($record) => $record->m_status_tabs === 2)
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Un-Publish Panduan Pendakian')
                        ->modalDescription('Apakah anda yakin ingin Un-Publish Panduan Pendakian ?')
                        ->modalSubmitActionLabel('Un-Publish Sekarang')
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make()->modalHeading('Hapus Berita Pendakian')->visible(fn($record) => $record->m_status_tabs === 3)
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
            'index' => Pages\ListPanduans::route('/'),
            'create' => Pages\CreatePanduan::route('/create'),
            'edit' => Pages\EditPanduan::route('/{record}/edit'),
        ];
    }
}
