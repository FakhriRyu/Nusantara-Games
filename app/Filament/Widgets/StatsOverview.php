<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(label:'Total Games', value:Game::count()),
            Stat::make(label:'Total Developers', value:Developer::count()),
            Stat::make(label:'Total Categories', value:Category::count()),
            Stat::make(label:'Total Reviews', value:Review::count()),
        ];

        
    }
}
