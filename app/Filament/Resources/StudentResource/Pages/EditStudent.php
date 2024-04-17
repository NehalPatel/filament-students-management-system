<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updatePassword')
                ->form([
                    TextInput::make('password')
                        ->required()
                        ->password()
                        ->confirmed(),
                    TextInput::make('password_confirmation')
                        ->required()
                        ->password(),
                ])->action(function(array $data){
                    $this->record->update(['password' => $data['password']]);

                    Notification::make()
                        ->title('Student Password Updated Successfully')
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
