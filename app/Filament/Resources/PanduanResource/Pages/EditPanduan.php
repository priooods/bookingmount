<?php

namespace App\Filament\Resources\PanduanResource\Pages;

use App\Filament\Resources\PanduanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPanduan extends EditRecord
{
    protected static string $resource = PanduanResource::class;
    protected ?string $heading = 'Ubah Data Panduan';
    protected static ?string $title = 'Ubah Panduan';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
