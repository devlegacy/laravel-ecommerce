<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * Get the product that owns the review.
     */
    public function post()
    {
        return $this->belongsTo(Product::class);
    }
}
