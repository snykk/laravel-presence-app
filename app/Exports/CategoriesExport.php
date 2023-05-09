<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategoriesExport implements FromCollection, ShouldQueue, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        $categories = Category::all();

        $categories->where('deleted_at', '!=', null);

        return $categories;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
        ];
    }

    public function map($categories): array
    {
        return[
            $categories->id,
            $categories->translations[0]->name,
        ];
    }

    public function title(): string
    {
        return 'Categories Data';
    }
}
