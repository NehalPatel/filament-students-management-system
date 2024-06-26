<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Stream;
use App\Models\Student;
use Filament\Forms\Get;
use App\Models\Division;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Exports\StudentsExport;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->autofocus(),
                TextInput::make('email')
                    ->required()
                    ->unique(ignoreRecord:true),
                Select::make('stream_id')
                    ->options(Stream::all()->pluck('name', 'id'))
                    ->live()
                    ->label('Stream'),

                Select::make('division_id')
                    ->options(fn (Get $get) => Division::where('stream_id', $get('stream_id'))->pluck('name', 'id')->toArray())
                    ->label('Division'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->description(fn(Student $record) : ?string => $record?->email ?? null)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('spdid')
                    ->label('SPDID')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('mobile')
                    ->label('Mobile')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('enrollment_no')
                    ->label('Enrollment No')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('stream.short_name')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge(),
                TextColumn::make('division.name')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('stream-section-filter')
                    ->form([
                        Select::make('stream_id')
                            ->live()
                            ->label('Filter By Stream')
                            ->placeholder('Select a Stream')
                            ->options(
                                Stream::pluck('name', 'id')->toArray(),
                            ),
                        Select::make('division_id')
                            ->label('Filter By Division')
                            ->placeholder('Select a Division')
                            ->options(function (Get $get) {
                                $streamId = $get('stream_id');
                                if ($streamId) {
                                    return Division::where('stream_id', $streamId)
                                        ->pluck('name', 'id')
                                        ->toArray();
                                }
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['stream_id'], function ($query) use ($data) {
                            return $query->where('stream_id', $data['stream_id']);
                        })->when($data['division_id'], function ($query) use ($data) {
                            return $query->where('division_id', $data['division_id']);
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('export')
                        ->label('Export to Excel')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function(Collection $records){
                            return Excel::download(new StudentsExport($records), 'students.xlsx');
                        }),
                    BulkAction::make('migrate')
                        ->label('Migrate Students')
                        ->icon('heroicon-o-bars-arrow-up')
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
                        ])
                        // ->modalSubmitActionLabel('Migrate Student(s)')
                        ->requiresConfirmation()
                        ->action(function(array $data, Collection $records){
                            $stream_id = (int) $data['stream_id'];
                            $division_id = (int) $data['division_id'];

                            $recordIds = $records->pluck('id')->toArray();

                            Student::whereIn('id', $recordIds)->update([
                                'stream_id' => $stream_id,
                                'division_id' => $division_id,
                            ]);
                        })
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
