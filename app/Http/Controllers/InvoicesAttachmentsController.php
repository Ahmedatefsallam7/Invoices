<?php

namespace App\Http\Controllers;

use App\Models\InvoicesAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg,mp3,mp4,txt'
        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون واحده من الاتي [ txt , mp4 , mp3 , pdf , jpeg , png , jpg ]'
        ]);

        $file = $request->file('file_name');
        $file_name = $file->getClientOriginalName();

        InvoicesAttachments::create([

            'file_name' => $file_name,
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->invoice_id,
            'created_by' => Auth::user()->name,

        ]);

        // put the file into public folder
        $fileName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $fileName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');

        return redirect()->back();
    }


    public function show()
    {
    }


    public function edit()
    {
    }


    public function update()
    {
    }


    public function destroy()
    {
    }
}