<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price'          => 'float',
        'discount'       => 'float',
        'discount_price' => 'float',
        'vat'            => 'float',
        'sub_total'      => 'float',
        'discount_rate'  => 'integer',
        'vat_rate'       => 'integer',
        'stock'          => 'integer',
        'is_active'      => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'barcode',
        'price',
        'discount_rate',
        'vat_rate',
        'stock',
        'is_active',
    ];

    /**
     * Get the reviews for the products.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
