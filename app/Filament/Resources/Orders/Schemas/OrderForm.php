<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Number;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // -------------------------
                // Order Information
                // -------------------------
                Section::make('Order Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->required()
                            ->columnSpanFull(),

                        ToggleButtons::make('status')
                            ->inline()
                            ->default('new')
                            ->required()
                            ->options([
                                'new' => 'New',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->colors([
                                'new' => 'info',
                                'processing' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            ])
                            ->columnSpanFull(),

                        Select::make('currency')
                            ->options([
                                'INR' => 'INR',
                                'USD' => 'USD',
                                'JPY' => 'JPY',
                            ])
                            ->default('INR')
                            ->required(),

                        Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'stripe' => 'Stripe',
                                'cod' => 'Cash On Delivery',
                            ])
                            ->required(),

                        Select::make('payment_status')
                            ->label('Payment Status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->default('pending')
                            ->required(),

                        Select::make('shipping_method')
                            ->label('Shipping Method')
                            ->options([
                                'DTDC' => 'DTDC',
                                'FedEx' => 'FedEx',
                                'Delhivery' => 'Delhivery',
                            ])
                            ->default('DTDC')
                            ->required(),


                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(3),

               
                Section::make('Order Items')
                    ->schema([
                        Repeater::make('items')->relationship()
                        ->schema([
                            Select::make('product_id')
                            ->relationship('product','name')
                            ->searchable()
                            ->preload()
                            ->distinct()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()->reactive()
                            ->afterStateUpdated(fn($state, Set $set) => $set 
                            ('unit_amount',Product::find($state)?->price ?? 0))
                            ->afterStateUpdated(fn($state, Set $set) => $set 
                            ('total_amount',Product::find($state)?->price ?? 0)),
                        
                            TextInput::make('quantity')->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)->required()->reactive()
                            ->afterStateUpdated(fn($state, Set $set,Get $get)
                            => $set('total_amount', $state*$get('unit_amount'))),

                            TextInput::make('unit_amount')
                            ->numeric()->required()->disabled()->dehydrated(),

                            TextInput::make('total_amount')
                            ->numeric()->required()->dehydrated(),

                        
                        ])->columns(2),

                        Placeholder::make('grand_total_placeholder')
                        ->label('Grand Total')
                        ->content(function(Get $get, Set $set){
                            $total = 0;
                            if(!$repeaters  =  $get('items')){
                                return $total;
                            }
                            foreach($repeaters as $key => $repeater){
                                    $total+= $get("items.{$key}.total_amount");      
                            }
                            $set ('grand_total', $total);
                            return Number::currency($total, 'INR');
                        }),
                            Hidden::make('grand_total')->default(0)->dehydrated()

                        
                    ])->columnSpanFull()
                   
            ]);
    }
}