<?php

namespace App\Filament\Resources\PanduanResource\Pages;

use App\Filament\Resources\PanduanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPanduans extends ListRecords
{
    protected static string $resource = PanduanResource::class;
    protected static ?string $title = 'Panduan';
    protected ?string $heading = 'Data Panduan';
    protected static ?string $breadcrumb = "List";
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
