<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    // public $timestamps = false;
    protected $fillable = [
        "invoice_number",
        "invoice_Date",
        "Due_date",
        "section_id",
        "product",
        "Amount_collection",
        "Amount_Commission",
        "Discount",
        "Value_VAT",
        "Rate_VAT",
        "Total",
        "status",
        "Value_Status",
        "note",
        "Payment_Date"

    ];


    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function invoiceDetails()
    {
        return $this->hasMany(InvoicesDetailes::class);
    }
    
    public function invoiceAttachments()
    {
        return $this->hasMany(InvoicesAttachments::class);
    }
}