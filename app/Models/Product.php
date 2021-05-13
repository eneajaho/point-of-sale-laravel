<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'name',
        'price',
        'low_stock',
        'optimal_stock',
        'barcode',
        'product_category_id'
    ];

    public function stock(){
        return $this->hasOne(Stock::class);
    }

    public function category(){
        return $this->hasOne(ProductCategory::class);
    }
}
