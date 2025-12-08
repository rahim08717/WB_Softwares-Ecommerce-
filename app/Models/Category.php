<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'is_active'];

    // রিলেশন: এক ক্যাটাগরির অনেক প্রোডাক্ট থাকে
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
