<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function CountAllInvoices()
    {
        $invoices = Invoice::all();
        $count = count($invoices);
        return view('dashboard', compact('count'));
    }
}