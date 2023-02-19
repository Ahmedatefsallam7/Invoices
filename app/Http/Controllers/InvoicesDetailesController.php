<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicesAttachments;
use App\Models\InvoicesDetailes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoicesDetailesController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
    }


    public function store()
    {
    }


    public function edit()
    {
    }


    public function show($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $details = InvoicesDetailes::where('id_Invoice', $id)->get();
        $attachments = InvoicesAttachments::where('invoice_id', $id)->get();
        // InvoiceController::MarkOneRead( $invoice);
        return view('Invoices.details_invoices', compact(['invoice', 'details', 'attachments']));
    }


    public function update()
    {
    }

    // function to destroy file 
    public function destroy(Request $request)
    {
        // to delete the file from DB
        $invoice = InvoicesAttachments::findOrFail($request->id_file);
        $invoice->delete();

        // to delete the file from public folder
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    // function to display the file  from public path 
    public function openFile($invoice_number, $file_name)

    {
        $path = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        return  response()->file($path);
    }

    // function to download the  file  from public path
    public function getFile($invoice_number, $file_name)

    {
        $path = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        return  response()->download($path);
    }
}