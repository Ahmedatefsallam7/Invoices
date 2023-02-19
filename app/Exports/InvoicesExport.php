<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class InvoicesExport implements FromView
{

    public function view(): View
    {
        return view('exports.invoice', [
            'invoices' => Invoice::all()
        ]);
    }
}