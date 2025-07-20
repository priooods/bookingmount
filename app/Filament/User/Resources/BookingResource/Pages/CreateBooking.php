<?php

namespace App\Filament\User\Resources\BookingResource\Pages;

use App\Filament\User\Resources\BookingResource;
use App\Models\MAdministrasiPayment;
use App\Models\MKuotaTabs;
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

        $start = Carbon::parse($this->data['start_climb'])->format('Y-m-d');
        $end = Carbon::parse($this->data['end_climb'])->format('Y-m-d');

        $findKuota = MKuotaTabs::where('m_status_tabs_id', 2)->first();
        if (!isset($findKuota)) {
            Notification::make()
                ->warning()
                ->title('Kuota tidak tersedia !')
                ->body('Kuota mendaki belum tersedia')
                ->persistent()
                ->send();

            $this->halt();
        }

        $climber = TClimbersTab::where('m_status_tabs', 4)->get();
        $monthKuota = Carbon::parse($findKuota->dates)->format('Y-m');
        $arr = array();
        foreach ($climber as $key => $value) {
            $dates = Carbon::parse($value['start_climb'])->format('Y-m');
            if ($monthKuota === $dates) {
                array_push($arr, $value);
            }
        }

        if ($findKuota->kuota === count($arr)) {
            Notification::make()
                ->warning()
                ->title('Kuota bulan ini penuh')
                ->body('Kuota mendaki dibulan ini sudah penuh')
                ->persistent()
                ->send();

            $this->halt();
        }

        if ($start > $end) {
            Notification::make()
                ->warning()
                ->title('Tanggal turun ilegal !')
                ->body('Tanggal turun anda salah, pastikan ulang')
                ->persistent()
                ->send();

            $this->halt();
        }

        if ($this->data['count_friend'] < 4) {
            Notification::make()
                ->warning()
                ->title('Teman mendaki kurang')
                ->body('Pastikan anda memiliki teman minimal 3 orang')
                ->persistent()
                ->send();

            $this->halt();
        }
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['m_status_tabs'] = 1;
        $data['created_by'] = auth()->user()->id;
        $adm = MAdministrasiPayment::where('m_status_tabs_id', 2)->first();
        $data['m_adm_id'] = $adm->id;
        return $data;
    }
}
