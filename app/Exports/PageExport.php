<?php

namespace App\Exports;

use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PageExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Campaign::all();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Budget', 'Status'];
    }

    public function map($campaign): array
    {
        return [
            $campaign->id,
            $campaign->name,
            $campaign->budget,
            $campaign->status,
        ];
    }
}
