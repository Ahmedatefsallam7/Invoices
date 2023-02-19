<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $fillable=['product_name','description','section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}