<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use App\Models\TClimbersTab;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;

class ReportResource extends Resource
{
    protected static ?string $model = TClimbersTab::class;
    protected static ?string $navigationLabel = 'Report';
    protected static ?string $breadcrumb = "Report";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function canCreate(): bool
    {
        return false;
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(
            [
                ComponentsSection::make('Informasi Pendaki')
                    ->description('Informasi Pendaki')
                    ->schema([
                        TextEntry::make('realname')->label('Nama Lengkap'),
                        TextEntry::make('nik')->label('NIK'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('phone')->label('No Handphone'),
                        TextEntry::make('gender')->label('Gender')->getStateUsing(fn($record) => $record->gender == 0 ? 'Wanita' : 'Pria'),
                        TextEntry::make('age')->label('Usia'),
                        TextEntry::make('address')->label('Alamat'),
                    ])->columns(2),
                ComponentsSection::make('Detail Pendakian')
                    ->description('Informasi Detail Pendakian')
                    ->schema([
                        TextEntry::make('count_friend')->label('Total Teman Pendakian'),
                        TextEntry::make('start_climb')->label('Tanggal Berangkat'),
                        TextEntry::make('end_climb')->label('Tanggal Turun'),
                        TextEntry::make('phone')->label('No Handphone'),
                    ])->columns(2),
                ComponentsSection::make('Kontak Darurat')
                    ->description('Informasi Kontak Darurat')
                    ->schema([
                        TextEntry::make('emergency_name')->label('Nama Kontak Darurat'),
                        TextEntry::make('emergency_phone')->label('No. Handphone Kontak Darurat'),
                    ])->columns(2),
                ComponentsSection::make('Kontak Darurat')
                    ->description('Informasi Kontak Darurat')
                    ->schema([
                        TextEntry::make('comment')->label('Catatan'),
                        ImageEntry::make('file_payment')->label('Bukti Pembayaran')->getStateUsing(function (TClimbersTab $record): string {
                            return $record->file_payment;
                        }),
                    ])->columns(2),
            ]
        );
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('realname')->label('Nama Lengkap')->placeholder('Masukan Nama Lengkap')->required(),
                TextInput::make('nik')->label('NIK Anda')->placeholder('Masukan NIK Anda')->numeric()->required(),
                TextInput::make('email')->label('Email Anda')->email()->placeholder('Masukan Email')->required(),
                TextInput::make('phone')->label('No Handphone')->placeholder('Masukan No Handphone')->numeric()->tel()->required(),
                Select::make('gender')
                    ->label('Pilih Gender')
                    ->placeholder('Pilih Gender')
                    ->options([
                        0 => 'Wanita',
                        1 => 'Pria',
                    ])
                    ->native(false)
                    ->searchable()
                    ->default(1)
                    ->required(),
                TextInput::make('age')->label('Usia Anda')->placeholder('Masukan Usia')->numeric()->suffix('Tahun')->required(),
                FileUpload::make('file_ktp')->label('Pilih File KTP')
                    ->uploadingMessage('Uploading attachment...')
                    ->reorderable()
                    ->preserveFilenames()
                    ->image()
                    ->directory('form-booking')
                    ->maxSize(5000)->required(),
                Textarea::make('address')->label('Alamat Lengkap Anda')->placeholder('Masukan Alamat Lengkap')->required(),
                Section::make('Detail Pendakian')->columns(2)->schema([
                    TextInput::make('count_friend')->label('Total Teman Pendakian')
                        ->placeholder('Masukan jumlah teman pendakian')
                        ->numeric()
                        ->suffix('Pendaki')
                        ->required(),
                    DateTimePicker::make('start_climb')->label('Tanggal Berangkat Pendakian')
                        ->placeholder('Pilih tanggal berangkat pendakian')
                        ->firstDayOfWeek(7)->seconds(false)
                        ->closeOnDateSelection()->required()
                        ->unique(modifyRuleUsing: static function (Unique $rule, Get $get) {
                            return $rule->where('start_climb', 'like', '%' . Carbon::parse($get('start_climb'))->format('d/m/Y') . '%');
                        }),
                    DateTimePicker::make('end_climb')->label('Tanggal Turun Pendakian')
                        ->placeholder('Pilih tanggal turun pendakian')
                        ->firstDayOfWeek(7)->seconds(false)
                        ->closeOnDateSelection()->required(),
                ])->dehydrated(true),
                Section::make('Kontak Darurat')->columns(2)->schema([
                    TextInput::make('emergency_name')->label('Nama Kontak Darurat')->placeholder('Masukan Nama Kontak Darurat')->required(),
                    TextInput::make('emergency_phone')->label('No. Handphone Kontak Darurat')->tel()->numeric()->placeholder('Masukan No. Handphone')->required(),
                ]),
                FileUpload::make('file_payment')->label('Upload Bukti Pembayaran')
                    ->uploadingMessage('Uploading attachment...')
                    ->reorderable()
                    ->preserveFilenames()
                    ->image()
                    ->directory('form-booking')
                    ->maxSize(5000)->required(),
                Textarea::make('comment')->label('Catatan Penolakan')->placeholder('Masukan Catatan')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(TClimbersTab::whereIn('m_status_tabs', [4,8])->orderBy('created_at'))
            ->columns([
            TextColumn::make('realname')->label('Nama Pendaki')->searchable(),
                TextColumn::make('nik')->label('NIK'),
                TextColumn::make('start_climb')->label('Tanggal Pendakian')->date(),
                TextColumn::make('end_climb')->label('Selesai Pendakian')->date(),
                TextColumn::make('m_status_tabs')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    'DRAFT' => 'gray',
                    'PUBLISH' => 'success',
                    'UNPUBLISH' => 'danger',
                    'APPROVED' => 'success',
                    'DI AJUKAN' => 'success',
                    'CANCELLED' => 'danger',
                    'DITOLAK' => 'danger',
                    'ON PROSES' => 'info',
                })->getStateUsing(fn($record) => $record->status ? $record->status->title : 'Tidak Ada'),
            ])
            ->filters([
                Filter::make('date_treatment')
                    ->form([
                        DatePicker::make('start_date')->label('Dari Tanggal'),
                        DatePicker::make('start_end')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_climb', '>=', $date),
                            )
                            ->when(
                                $data['start_end'],
                                fn(Builder $query, $date): Builder => $query->whereDate('end_climb', '<=', $date),
                            );
                    })
                ])
            ->actions([
                Tables\Actions\ViewAction::make()->modalHeading('Detail Informasi Booking'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
