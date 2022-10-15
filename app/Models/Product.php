<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $dates = [
        'expiration',
        
    ];

    protected $fillable = [
        'image',
        'name',
        'category_id',
        'description',
        'expiration',
        'price',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id' , 'id')->latest();
    }
    public function reviewsIsStar()
    {
        return $this->hasMany(Review::class, 'product_id' , 'id')->where('isStar', true)->count();
    }
}
