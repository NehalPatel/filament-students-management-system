<?php

namespace App\Filament\Widgets;

use App\Models\Stream;
use App\Models\Student;
use App\Models\Division;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Streams',  Stream::count()),
            Stat::make('Total Divisions', Division::count()),
            Stat::make('Total Students', Student::count()),
        ];
    }
}
