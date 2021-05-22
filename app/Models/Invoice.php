<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'total',
        'is_paid',
        'user_id',
        'shift_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoiceProducts(){
        return $this->hasMany(InvoiceProducts::class);
    }
}
