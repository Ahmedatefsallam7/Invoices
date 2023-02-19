<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Invoice;
use App\Models\InvoicesAttachments;
use App\Models\InvoicesDetailes;
use App\Models\Section;
use App\Models\User;
use App\Notifications\SendNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{

    public function index()
    {
        $headers = Invoice::get();
        $details = InvoicesDetailes::get();
        return view('invoices.invoices', compact('headers', 'details'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('Invoices.add_invoice', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'invoice_number' => 'unique:invoices',
            ],
            [
                'invoice_number.unique' => 'رقم الفاتوره مستخدم من قبل'
            ]

        );


        // store in Invoice table
        Invoice::create([
            "invoice_number" => $request->invoice_number,
            "invoice_Date" => $request->invoice_Date,
            "Due_date" => $request->Due_date,
            "section_id" => $request->Section,
            "product" => $request->product,
            "Amount_collection" => $request->Amount_collection,
            "Amount_Commission" => $request->Amount_Commission,
            "Discount" => $request->Discount,
            "Value_VAT" => $request->Value_VAT,
            "Rate_VAT" => $request->Rate_VAT,
            "Total" => $request->Total,
            "status" => 'غير مدفوعه',
            "Value_Status" => 2,
            "note" => $request->note
        ]);

        // store in InvoicesDetailes table
        $invoice_id = Invoice::latest()->first()->id;
        InvoicesDetailes::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);


        // store in InvoicesAttachments table
        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new InvoicesAttachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic to public $path
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        // send mail to user who make login when he make he add a new invoice 
        // $user = auth()->user()->email;
        // Mail::to($user)->send(new AddInvoice($invoice_id));

        // send notification to user who make login when he make he add a new invoice 
        // $user = User::first('email');
        // Notification::send($user, new SendNotify($invoice_id));

        // send notification when the user add invoice and store it in Database
        // $user = User::find(Auth::user()->id);
        $user = User::get();
        $invoice_id = Invoice::latest()->first();
        Notification::send($user, new SendNotify($invoice_id));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect()->back();
    }

    public function show()
    {
        $invoice = Invoice::all();
        return view('Invoices.details_invoices', compact('invoice'));
    }


    public function statusShow($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        return view('invoices.changeStatus', compact('invoice'));
    }


    // change status payment and the date
    public function updateStatus(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($request->status === 'مدفوعه') {
            $invoice->update([

                'Value_Status' => 1,
                'Status' => $request->status,
                'Payment_Date' => $request->payDate,
            ]);

            InvoicesDetailes::create([

                'id_Invoice' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'Status' => $request->status,
                'Value_Status' => 1,
                'PaymentDate' => $request->payDate,
                'note' => $request->note,
                'user' => Auth::user()->name,
            ]);
        } else {
            $invoice->update([

                'Value_Status' => 3,
                'Status' => $request->status,
                'Payment_Date' => $request->payDate,
            ]);

            InvoicesDetailes::create([

                'id_Invoice' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'Status' => $request->status,
                'Value_Status' => 3,
                'PaymentDate' => $request->payDate,
                'note' => $request->note,
                'user' => Auth::user()->name,
            ]);
        }

        session()->flash('edit', 'تم تحديث حالة الدفع');
        return to_route('invoices.index');
    }


    public function edit($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        $sections = Section::all();

        return view('Invoices.edit_invoice', compact('invoices', 'sections'));
    }


    // update this invoice in the table invoice
    public function update(Request $request)
    {
        Invoice::findOrFail($request->id)->update([

            "invoice_number" => $request->invoice_number,
            "invoice_Date" => $request->invoice_Date,
            "Due_date" => $request->Due_date,
            "section_id" => $request->Section,
            "product" => $request->product,
            "Amount_collection" => $request->Amount_Collection,
            "Amount_Commission" => $request->Amount_Commission,
            "Discount" => $request->Discount,
            "Value_Vat" => $request->Value_Vat,
            "Rate_Vat" => $request->Rate_Vat,
            "Total" => $request->Total,
            "note" => $request->note
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect()->back();
    }

    //softDeletes
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = Invoice::where('id', $id)->first();

        // remove the files from public folder
        $attachment = InvoicesAttachments::where('invoice_id', $id)->first();
        if (!empty($attachment->invoice_number)) {

            $path = $attachment->invoice_number;
            Storage::disk('public_uploads')->deleteDirectory($path);
        }

        $invoice->forceDelete();

        session()->flash('delete', 'تم حذف الفاتوره بنجاح');
        return redirect()->back();
    }



    public function invoice_Paid()
    {
        $invoices = Invoice::where('Value_Status', 1)->get();
        return view('invoices.invoices_Paid', compact('invoices'));
    }

    public function invoice_Unpaid()
    {
        $invoices = Invoice::where('Value_Status', 2)->get();
        return view('invoices.invoices_Unpaid', compact('invoices'));
    }

    public function invoice_Partial()
    {
        $invoices = Invoice::where('Value_Status', 3)->get();
        return view('invoices.invoices_Partial', compact('invoices'));
    }


    public function printInvoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('Invoices.print_invoice', compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'قائمة الفواتير.xlsx');
    }

    // static function  MarkOneRead($id)
    // {
    //     if (\App\Models\Invoice::find($id)) {
    //         foreach (auth()->user()->unreadNotifications as  $value) {

    //             $value->markAsRead();
    //             break;
    //         }
    //     }
    // }
    function  MarkAllRead()
    {
        $unReads = auth()->user()->unreadNotifications;
        foreach ($unReads as $read) {
            $read->markAsRead();
        }
        return back();
    }
}