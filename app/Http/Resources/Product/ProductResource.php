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
        $discountPrice = (float) bcmul(bcsub(1, bcdiv($this->percentage_discount, 100, 2), 2), $this->price, 2);
        $discount = (float) bcsub($this->price, $discountPrice, 2);
        // 'products.(show|store|update)'
        // 'products.show', 'products.store', 'products.update'
        $reviews = request()->routeIs(...['products.show', 'products.store', 'products.update']);
        $isProductShow = request()->routeIs('products.show');
        $isProductIndex = request()->routeIs('products.index');

        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'description'        => $this->when($isProductShow, $this->description),
            'price'              => $this->when($isProductShow, $this->price),
            'percentageDiscount' => $this->when($isProductShow, $this->percentage_discount), // percentage discount
            'discountPrice'      => $discountPrice,
            'discount'           => $this->when($isProductShow, $discount), // ahora $0.0 pesos
            'stock'              => $this->when($isProductShow, $this->stock === 0 ? 'Out of stock' : $this->stock),
            'image'              => $this->when($isProductShow, $this->image),
            'rating'             => $this->reviews->count() > 0 ? bcdiv($this->reviews->sum('stars'), $this->reviews->count(), 2) : 'No rating yet',
            'href'               => [
                'reviews' => $this->when($reviews, route('reviews.index', $this->id)),
                'link'    => $this->when($isProductIndex, route('products.show', $this->id)),
            ],
        ];
    }
}
