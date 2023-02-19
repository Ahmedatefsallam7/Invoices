<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view('Invoices.invoice_reports');
    }

    public function SearchInvoices(Request $request)
    {
        $radio = $request->radio;

        // search with invoice type
        if ($radio == 1) {
            // if not select date
            if ($request->type && $request->start_at == "" && $request->end_at == "") {


                $invoices = Invoice::select('*')->where('Value_Status', '=', $request->type)->get();
                $type = $request->type;
                return view('Invoices.invoice_reports', compact(['type', 'invoices']))/*->withDetails($invoices)*/;
            }
            if ($request->type == '0' && $request->start_at == "" && $request->end_at == "") {


                $invoices = Invoice::/*select('*')->where('Value_Status','=', $request->type)->*/get();
                $type = $request->type;
                return view('Invoices.invoice_reports', compact(['type', 'invoices']))/*->withDetails($invoices)*/;
            }

            // if select date
            else {
                $start = date($request->start_at);
                $end = date($request->end_at);
                $type = $request->type;
                $invoices = Invoice::whereBetween('invoice_Date', [$start, $end])->where('Value_Status', '=', $request->type)->get();
                return view('Invoices.invoice_reports', compact(['type', 'start', 'end', 'invoices']))/*->withDetails($invoices)*/;
            }
        }


        // search with invoice number
        else {

            $invoices = Invoice::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('Invoices.invoice_reports', compact('invoices'));
        }
    }

    public function create_customer_report()
    {
        $sections = Section::all();
        return view('Invoices.customers_report', compact('sections'));
    }

    function CustomerSearch(Request $request)
    {
        if ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {

            $invoices = Invoice::select('*')->where('section_id', $request->section)->where('product', $request->product)->get();
            $sections = Section::all();
            return view('Invoices.customers_report', compact(['invoices', 'sections']));
        } else {

            $start = date($request->start_at);
            $end = date($request->end_at);

            $invoices = Invoice::select('*')->whereBetween('invoice_date', [$start, $end])->where('section_id', $request->section)->where('product', $request->product)->get();
            $sections = Section::all();
            return view('Invoices.customers_report', compact(['invoices', 'sections']));
        }
    }
}