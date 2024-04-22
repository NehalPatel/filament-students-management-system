<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DivisionResource\Pages;
use App\Filament\Resources\DivisionResource\RelationManagers;
use App\Models\Division;
use App\Models\Stream;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class DivisionResource extends Resource
{
    protected static ?string $model = Division::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'Academic Management';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique(ignoreRecord:true, modifyRuleUsing: function(Get $get, Unique $rule){
                        return $rule->where('stream_id', $get('stream_id'));
                    })
                    ->required(),
                Select::make('stream_id')
                    ->options(Stream::pluck('name', 'id'))
                    ->label('Stream')
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stream.name')
                    ->sortable(),
                TextColumn::make('students_count')
                    ->counts('students')
                    ->badge(),
            ])
            ->defaultSort('stream.name')
            ->filters([
                SelectFilter::make('stream_id')
                    ->options(Stream::all()->pluck('short_name', 'id'))
                    ->label('Stream'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDivisions::route('/'),
            'create' => Pages\CreateDivision::route('/create'),
            'edit' => Pages\EditDivision::route('/{record}/edit'),
        ];
    }
}
