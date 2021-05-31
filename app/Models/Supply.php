<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'before_supply',
        'after_supply',
        'created_at',
        'product_id',
        'stock_id',
        'category_id'
    ];

    public function stock(){
        return $this->belongsTo(Stock::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
