<?php

namespace App\Filament\Resources\KuotaResource\Pages;

use App\Filament\Resources\KuotaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKuotas extends ListRecords
{
    protected static string $resource = KuotaResource::class;
    protected static ?string $title = 'Kuota Pendaki';
    protected ?string $heading = 'Data Kuota Pendaki';
    protected static ?string $breadcrumb = "List";
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
