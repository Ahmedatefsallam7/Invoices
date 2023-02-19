<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesDetailes extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id_Invoice',
        'invoice_number',
        'product',
        'section',
        'Status',
        'Value_Status',
        'note',
        'PaymentDate',
        'user',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}