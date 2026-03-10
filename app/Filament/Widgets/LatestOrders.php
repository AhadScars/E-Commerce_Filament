<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;


class LatestOrders extends TableWidget
{
    protected string | array | int $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
    

            ->query(OrderResource::getEloquentQuery())->DefaultPaginationPageOption(5)

            ->columns([

                TextColumn::make('id')
                    ->searchable()->label('Order ID'),
                TextColumn::make('user.name'),
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
                //
            ])
            ->recordActions([
                //
            ])
            ->actions([
                Action::make('view_order')
                    ->label('View Order')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record])),

                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
