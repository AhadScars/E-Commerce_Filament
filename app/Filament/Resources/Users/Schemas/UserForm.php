<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("name")->required()->rule('min:3'),
                TextInput::make("email")->required()->unique()->email()->label("Email Address"),
                TextInput::make("password")->password()->required()->rules(['min:8']),
                TextInput::make("password_confirmation")
                    ->password()
                    ->required()
                    ->same('password')
                    ->label("Confirm Password"),
                DateTimePicker::make('Email_Verified_At')->label('Email_Verified_At')->default(now()),
            ]);
    }
}
