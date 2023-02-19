<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceArchiveController extends Controller
{
    // show invoices Archive 
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('Invoices.invoiceArchive', compact('invoices'));
    }

    // make invoice archive
    public function destroy(Request $request)
    {
        $invoices = Invoice::where('id', $request->invoice_id)->first();
        $invoices->delete();

        session()->flash('delete', 'تم نقل الفاتوره الي الارشيف');
        return to_route('invoices.index');
    }

    public function restoreInvoice(Request $request)
    {
        Invoice::onlyTrashed()->where('id', $request->invoice_id)->restore();

        session()->flash('restore', 'تم استعادة الفاتوره');
        return redirect()->back();
    }
    public function deleteInvoice(Request $request)
    {
        Invoice::onlyTrashed()->where('id', $request->invoice_id)->forceDelete();

        session()->flash('delete', 'تم حذف الفاتوره');
        return redirect()->back();
    }
}