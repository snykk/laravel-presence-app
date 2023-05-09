<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class PromoTemplateExportEmpty implements FromView, WithTitle
{
    public function view(): View
    {
        return view('exports.promo-template-empty');
    }

    public function title(): string
    {
        return 'Bulk Import Promo Template';
    }
}
