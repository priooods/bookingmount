<?php

namespace App\Filament\Resources\KuotaResource\Pages;

use App\Filament\Resources\KuotaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKuota extends CreateRecord
{
    protected static string $resource = KuotaResource::class;
    protected ?string $heading = 'Tambah Data Kuota';
    protected static ?string $title = 'Tambah Kuota';
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
