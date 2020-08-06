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
        $discountPrice = bcmul(bcsub(1, bcdiv($this->discount, 100, 2), 2), $this->price, 2);

        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'description'        => $this->routeIs('products.show', $this->description),
            'price'              => $this->routeIs('products.show', $this->price),
            'percentageDiscount' => $this->routeIs('products.show', $this->discount), // percentage discount
            'discountPrice'      => $discountPrice,
            'discount'           => $this->routeIs('products.show', bcsub($this->price, $discountPrice, 2)),
            'stock'              => $this->routeIs('products.show', $this->stock === 0 ? 'Out of stock' : $this->stock),
            'image'              => $this->routeIs('products.show', $this->image),
            'rating'             => $this->reviews->count() > 0 ? bcdiv($this->reviews->sum('stars'), $this->reviews->count(), 2) : 'No rating yet',
            'href'               => [
                'reviews' => $this->routeIs('products.show', route('reviews.index', $this->id)),
                'link'    => $this->routeIs('products.index', route('products.show', $this->id)),
            ],
        ];
    }

    private function routeIs(string $name, $data)
    {
        return $this->when(request()->routeIs($name), $data);
    }
}
