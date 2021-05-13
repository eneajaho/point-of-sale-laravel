<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price',
        'total',
        'product_id',
        'invoice_id'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
