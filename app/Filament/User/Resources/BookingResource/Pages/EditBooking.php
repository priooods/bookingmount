<?php

namespace App\Filament\User\Resources\BookingResource\Pages;

use App\Filament\User\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;
    protected ?string $heading = 'Ubah Data Booking';
    protected static ?string $title = 'Ubah Booking';
    protected static bool $canCreateAnother = false;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
