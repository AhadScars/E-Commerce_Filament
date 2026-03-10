<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
            ->components([
                TextInput::make('name')
                    ->required()->rules(['min:3'])
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
                    ->unique(Brand::class, 'slug', ignoreRecord: true),

                FileUpload::make('image')
                    ->image()->required()->directory('brands'),

                Toggle::make('is_active')
                    ->required()->default(true),
            ]);
    }
}
