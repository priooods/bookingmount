<?php

namespace App\Filament\Resources\AdministrasiResource\Pages;

use App\Filament\Resources\AdministrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdministrasi extends CreateRecord
{
    protected static string $resource = AdministrasiResource::class;
    protected ?string $heading = 'Tambah Data Adm';
    protected static ?string $title = 'Tambah Adm';
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['m_status_tabs_id'] = 1;
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
