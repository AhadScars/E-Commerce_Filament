<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('phone_number')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('state')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('zip_code')
                    ->required()
                    ->maxLength(255),
                    
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Information')
            ->columns([
                TextColumn::make('first_name')->label('First Name')
                    ->searchable(),
                    TextColumn::make('last_name')->label('Last Name')
                    ->searchable(),
                    TextColumn::make('phone_number')->label('Phone Number')
                    ->searchable(),
                    TextColumn::make('city')->label('City')
                    ->searchable(),
                    TextColumn::make('state')->label('State')
                    ->searchable(),
                   
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
