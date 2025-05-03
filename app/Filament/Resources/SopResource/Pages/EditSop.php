<?php

namespace App\Filament\Resources\SopResource\Pages;

use App\Filament\Resources\SopResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSop extends EditRecord
{
    protected static string $resource = SopResource::class;
    protected ?string $heading = 'Ubah Data SOP';
    protected static ?string $title = 'Ubah SOP';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
