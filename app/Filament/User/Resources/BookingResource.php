<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BookingResource\Pages;
use App\Models\TClimbersTab;
use Carbon\Carbon;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Validation\Rules\Unique;

class BookingResource extends Resource
{
    protected static ?string $model = TClimbersTab::class;
    protected static ?string $navigationLabel = 'Booking';
    protected static ?string $breadcrumb = "Booking";
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        ->unique(modifyRuleUsing: static function (Unique $rule, Get $get){
                            return $rule->where('start_climb', 'like' , '%'. Carbon::parse($get('start_climb'))->format('d/m/Y') . '%');
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('realname')->label('Nama Anda')->searchable(),
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
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->visible(fn($record) => $record->m_status_tabs === 1),
                    Action::make('published')
                        ->label('Booking')
                        ->action(function ($record) {
                            $record->update([
                                'm_status_tabs' => 7,
                            ]);
                        })
                        ->visible(fn($record) => ($record->m_status_tabs === 1 || $record->m_status_tabs === 5))
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Ajukan Booking Pendakian')
                        ->modalDescription('Apakah anda yakin ingin Ajukan Booking Pendakian ?')
                        ->modalSubmitActionLabel('Ajukan Sekarang')
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')),
                    Action::make('unpublished')
                        ->label('Cancel')
                        ->action(function ($record) {
                            $record->update([
                                'm_status_tabs' => 5,
                            ]);
                        })
                        ->visible(fn($record) => $record->m_status_tabs === 7)
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Cancel Booking Pendakian')
                        ->modalDescription('Apakah anda yakin ingin Cancel Booking Pendakian ?')
                        ->modalSubmitActionLabel('Cancel Sekarang')
                        ->modalCancelAction(fn(StaticAction $action) => $action->label('Batal')),
                    Tables\Actions\ViewAction::make()->visible(fn($record) => $record->m_status_tabs === 4)
                        ->modalHeading('Informasi Booking Pendakian')
                        ->modalDescription('Tunjukan informasi ini pada petugas registrasi camp'),
                    Tables\Actions\DeleteAction::make()->modalHeading('Hapus Booking Pendakian')
                        ->action(function ($record) {
                            $record->delete();
                        })
                        ->visible(fn($record) => ($record->m_status_tabs === 1 || $record->m_status_tabs === 5))
                ])
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
