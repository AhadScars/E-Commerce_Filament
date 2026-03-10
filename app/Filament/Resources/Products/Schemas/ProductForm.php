<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([


                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Product Information')
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, $set) {
                                        if ($operation === 'create') {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Product::class, 'slug', ignoreRecord: true),

                                MarkdownEditor::make('description')
                                    ->default(null)
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('products'),
                            ]),

                        Section::make('Media')
                            ->schema([
                                FileUpload::make('images')
                                    ->required()
                                    ->multiple()
                                    ->directory('products')
                                    ->maxFiles(5)
                                    ->reorderable(),
                            ]),
                    ]),


                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Pricing')
                            ->schema([
                                TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('INR'),
                            ]),

                        Section::make('Association')
                            ->schema([
                                Select::make('category_id')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->relationship('category', 'name'),

                                Select::make('brands_id')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->relationship('brand', 'name'),
                            ]),

                        Section::make('Status')
                            ->schema([
                                Toggle::make('in_stock')->required()->default(true),
                                Toggle::make('is_active')->required()->default(true),
                                Toggle::make('is_featured')->required(),
                                Toggle::make('on_sale')->required(),
                            ]),
                    ]),
            ]);
    }
}