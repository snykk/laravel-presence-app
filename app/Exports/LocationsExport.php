<?php

namespace App\Exports;

use App\Models\Location;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class LocationsExport implements FromCollection, ShouldQueue, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        $locations = Location::all();

        $locations->where('deleted_at', '!=', null);

        return $locations;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Title',
        ];
    }

    public function map($locations): array
    {
        return [
            $locations->id,
            $locations->title,
        ];
    }

    public function title(): string
    {
        return 'Locations Data';
    }
}
