<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Imports\StudentsImport;
use App\Models\Division;
use App\Models\Stream;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importStudents')
                ->label('Import Students')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->form([
                    Select::make('stream_id')
                        ->options(Stream::all()->pluck('name', 'id'))
                        ->live()
                        ->label('Stream'),
                    Select::make('division_id')
                        ->live()
                        ->options(function (Get $get) {
                                return Division::where('stream_id', $get('stream_id'))->pluck('name', 'id')->toArray();
                            })
                        ->label('Division'),
                    FileUpload::make('attachment')
                ])
                ->action(function (array $data){
                    $file = public_path('storage/'.$data['attachment']);
                    Excel::import(new StudentsImport((int) $data['stream_id'], (int) $data['division_id']), $file);

                    Notification::make()
                        ->title('Students imported successfully')
                        ->success()
                        ->send();
                })
        ];
    }
}
