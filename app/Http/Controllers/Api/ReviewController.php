<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\Review\ReviewCollection;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        return new ReviewCollection($product->reviews);
    }
}
