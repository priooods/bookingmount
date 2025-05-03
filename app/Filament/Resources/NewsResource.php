<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\TNewsTab;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = TNewsTab::class;
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $breadcrumb = "Berita";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Judul Berita')->placeholder('Masukan judul berita')->required(),
                Textarea::make('description')->label('Deskripsi Berita')->placeholder('Masukan deskripsi berita')->required(),
                TextInput::make('filename')->label('Nama File')->placeholder('Masukan nama file berita')->required(),
                FileUpload::make('file_path')->label('Pilih File Berita')
                    ->uploadingMessage('Uploading attachment...')
                    ->reorderable()
                    ->preserveFilenames()
                    ->image()
                    ->directory('form-berita')
                    ->maxSize(5000)->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul Berita'),
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
                    ->modalHeading('Publish Berita Pendakian')
                    ->modalDescription('Apakah anda yakin ingin Publish Berita Pendakian ?')
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
                    ->modalHeading('Un-Publish Berita Pendakian')
                    ->modalDescription('Apakah anda yakin ingin Un-Publish Berita Pendakian ?')
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
