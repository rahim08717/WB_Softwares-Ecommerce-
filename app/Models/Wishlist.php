<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];

    // পণ্য চেনার জন্য রিলেশন
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
