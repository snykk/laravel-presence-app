<?php

namespace App\Exports;

use App\Models\Brand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BrandsExport implements FromCollection, ShouldQueue, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        $brands = Brand::all();

        $brands->where('deleted_at', '!=', null);

        return $brands;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Title',
        ];
    }

    public function map($brands): array
    {
        return [
            $brands->id,
            $brands->title,
        ];
    }

    public function title(): string
    {
        return 'Brands Data';
    }
}
