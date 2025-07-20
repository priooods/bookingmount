<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction as PagesExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;
    protected static ?string $title = 'Report';
    protected ?string $heading = 'Report Pendakian';
    protected static ?string $breadcrumb = "List";
    protected function getHeaderActions(): array
    {
        return [
            PagesExportAction::make()->color('success')->exports([
                ExcelExport::make()->withColumns([
                    Column::make('realname')->heading('Nama Lengkap'),
                    Column::make('nik')->heading('NIK'),
                    Column::make('phone')->heading('Phone'),
                    Column::make('email')->heading('Email'),
                    Column::make('address')->heading('Alamat'),
                    Column::make('gender')->heading('Gender')->formatStateUsing(
                        fn($record) => $record->gender === 0 ? 'Wanita' : 'Pria'
                    ),
                    Column::make('age')->heading('Usia'),
                    Column::make('start_climb')->heading('Berangkat'),
                    Column::make('end_climb')->heading('Pulang'),
                    Column::make('end_climb')->heading('Pulang'),
                    Column::make('m_adm_id')->heading('Biaya Adm')->formatStateUsing(
                        fn($record) => $record?->biaya_adm?->price ?? 0
                    ),
                ])->withFilename('Report Pendaki'),
            ]),
            Actions\CreateAction::make(),
        ];
    }
}
