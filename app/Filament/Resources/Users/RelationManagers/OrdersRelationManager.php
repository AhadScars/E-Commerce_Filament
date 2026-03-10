<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
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
use Filament\Actions\Action;


class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->searchable()->label('Order ID'),
                TextColumn::make('grand_total')->money('INR'),
                TextColumn::make('status'),
                TextColumn::make('payment_status'),
                TextColumn::make('payment_method'),
                TextColumn::make('created_at')->label('Created At'),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->actions([
                Action::make('view_order')
                    ->label('View Order')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record])),

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
