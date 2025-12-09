<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', // নতুন ফিল্ড
        'title',
        'subtitle',
        'image', // এটা এখন অপশনাল, যদি কেউ কাস্টম ইমেজ দিতে চায়
        'link',
        'order',
        'is_active'
    ];

    // প্রোডাক্টের সাথে সম্পর্ক
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
