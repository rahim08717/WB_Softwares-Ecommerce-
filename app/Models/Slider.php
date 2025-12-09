<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'subtitle',
        'image',
        'link',
        'order',
        'is_active'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
