<?php

namespace App\Filament\Widgets;

use App\Models\WorkOrder;
use Filament\Widgets\ChartWidget;

class WorkOrderStatusChart extends ChartWidget
{
    protected ?string $heading = 'Work Orders by Status';

    protected static ?int $sort = 2;

    protected ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $statuses = ['open', 'in_progress', 'on_hold', 'completed', 'closed'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[] = WorkOrder::where('status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Work Orders',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#38bdf8', // open - sky
                        '#fbbf24', // in_progress - amber
                        '#94a3b8', // on_hold - slate
                        '#34d399', // completed - emerald
                        '#64748b', // closed - gray
                    ],
                ],
            ],
            'labels' => ['Open', 'In Progress', 'On Hold', 'Completed', 'Closed'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
