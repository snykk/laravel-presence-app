<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetPromoTemplate implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new PromoTemplateExport(),
            new BrandsExport(),
            new LocationsExport(),
            new CategoriesExport(),
        ];
    }
}
