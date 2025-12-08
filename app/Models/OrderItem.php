<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price'];

    // রিলেশন: আইটেমটি কোন অর্ডারের
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // রিলেশন: আইটেমটি আসলে কোন প্রোডাক্ট
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
