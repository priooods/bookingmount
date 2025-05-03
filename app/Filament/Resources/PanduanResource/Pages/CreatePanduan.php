<?php

namespace App\Filament\Resources\PanduanResource\Pages;

use App\Filament\Resources\PanduanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePanduan extends CreateRecord
{
    protected static string $resource = PanduanResource::class;
    protected ?string $heading = 'Tambah Data Panduan';
    protected static ?string $title = 'Tambah Panduan';
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['m_status_tabs'] = 1;
        return $data;
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Data');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('create');
    }
}
