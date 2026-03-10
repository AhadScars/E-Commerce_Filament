<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Order', Order::query()->where('status', 'new')->count()),
            Stat::make('Processing Order', Order::query()->where('status', 'processing')->count()),
            Stat::make('Shipped Order', Order::query()->where('status', 'shipped')->count()),
            Stat::make(
                'Average Price',
                Number::currency(Order::avg('grand_total'), 'INR')
            )
        ];
    }
}
