<?php

namespace App\Filament\User\Resources\BookingResource\Pages;

use App\Filament\User\Resources\BookingResource;
use App\Models\TClimbersTab;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
    protected ?string $heading = 'Tambah Data Booking';
    protected static ?string $title = 'Tambah Booking';
    protected static bool $canCreateAnother = false;

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Buat Booking');
    }

    protected function beforeCreate(): void
    {
        $find = TClimbersTab::where('start_climb', 'like' , '%'. Carbon::parse($this->data['start_climb'])->format('Y-m-d') . '%')
            ->orWhere('end_climb', 'like', '%' . Carbon::parse($this->data['end_climb'])->format('Y-m-d') . '%')->first();
        if ($find) {
            Notification::make()
                ->warning()
                ->title('Tanggal sudah ada !')
                ->body('Anda sudah membuat tanggal yang sama sebelumnya')
                ->persistent()
                ->send();

            $this->halt();
        }
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['m_status_tabs'] = 1;
        $data['created_by'] = auth()->user()->id;
        return $data;
    }
}
