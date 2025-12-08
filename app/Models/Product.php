<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'category_id', 'description',
        'price', 'image', 'stock', 'is_active'
    ];

    // রিলেশন: প্রোডাক্ট একটি ক্যাটাগরির আন্ডারে থাকে
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
