<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_status',
        'address'
    ];

    // ১. অর্ডারের মালিক (User) কে চেনার জন্য এই ফাংশনটি মিসিং ছিল
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ২. অর্ডারের আইটেমগুলো পাওয়ার জন্য
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
