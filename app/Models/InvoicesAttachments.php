<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesAttachments extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

        'file_name',
        'invoice_number',
        'invoice_id',
        'created_by',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}