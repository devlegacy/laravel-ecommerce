<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'description'      => $this->description,
            'price'            => $this->price,
            'discount'         => $this->discount,
            'stock'            => $this->stock === 0 ? 'Out of stock' : $this->stock,
            'image'            => $this->image,
            'rating'           => $this->reviews->count() > 0 ? bcdiv($this->reviews->sum('stars'), $this->reviews->count(), 2) : 'No rating yet',
            'href'             => [
                'reviews' => route('reviews.index', $this->id),
            ],
        ];
    }
}
