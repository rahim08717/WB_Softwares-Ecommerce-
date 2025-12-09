<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'old_price',
        'image',
        'stock',
        'is_active' // old_price যোগ করা হলো
    ];
    // রিলেশন: প্রোডাক্ট একটি ক্যাটাগরির আন্ডারে থাকে
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Review রিলেশন
    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_active', true);
    }

    // গড় রেটিং বের করার জন্য (Optional helper)
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
