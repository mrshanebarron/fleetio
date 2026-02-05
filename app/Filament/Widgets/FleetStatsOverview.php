<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use App\Models\Part;
use App\Models\WorkOrder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FleetStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Assets', Asset::count())
                ->description(Asset::where('status', 'active')->count() . ' active')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary')
                ->chart([4, 6, 8, 7, 10, 12, 12]),

            Stat::make('Open Work Orders', WorkOrder::whereIn('status', ['open', 'in_progress'])->count())
                ->description(WorkOrder::where('priority', 'critical')->whereIn('status', ['open', 'in_progress'])->count() . ' critical')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning')
                ->chart([2, 4, 3, 5, 4, 6, 5]),

            Stat::make('Overdue PM', MaintenanceSchedule::where('status', 'active')
                ->where('next_due_at', '<', now())
                ->count())
                ->description('Preventive maintenance')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger')
                ->chart([1, 2, 1, 3, 2, 4, 3]),

            Stat::make('Low Stock Parts', Part::whereColumn('quantity_on_hand', '<=', 'minimum_quantity')->count())
                ->description('Below minimum')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([3, 2, 4, 3, 5, 4, 6]),
        ];
    }
}
