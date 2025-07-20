<?php

namespace App\Filament\Resources\AdministrasiResource\Pages;

use App\Filament\Resources\AdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdministrasis extends ListRecords
{
    protected static string $resource = AdministrasiResource::class;
    protected static ?string $title = 'Biaya Administrasi';
    protected ?string $heading = 'Data Biaya Administrasi';
    protected static ?string $breadcrumb = "List";
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
