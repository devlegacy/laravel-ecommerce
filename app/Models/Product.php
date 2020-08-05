<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'stock',
        'price',
        'is_active',
    ];

    /**
     * Get the reviews for the products.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
