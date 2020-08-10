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
        $price = (float) $this->price; // total
        $discountPrice = (float) $this->discount_price; // Real price
        $discount = (float) $this->discount;
        $subTotal = (float) $this->sub_total;
        $vat = (float) $this->vat;

        $decimalDiscount = (float) bcdiv($this->discount_rate, 100, 2);
        $decimalVAT = (float) bcdiv($this->vat_rate, 100, 2);

        $reviews = request()->routeIs(...['products.show', 'products.store', 'products.update']);
        $isProductShow = request()->routeIs('products.show');
        $isProductIndex = request()->routeIs('products.index');

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->when($isProductShow, $this->description),
            'prices'      => [
                'subTotal' => $subTotal,
                'discount' => (float) $discountPrice,
                'total'    => $this->when($isProductShow, $price),
            ],
            'taxes' => [
                'vat' => [ // iva
                    'rate'   => $decimalVAT,
                    'amount' => $this->when($isProductShow, $vat), // impuesto $0.0 pesos | importe
                ],
            ],
            'discount'           => [
                'rate'   => $this->when($isProductShow, $decimalDiscount),
                'amount' => $this->when($isProductShow, $discount),  // ahorras $0.0 pesos | importe
            ],
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
// 'totalPrice'              => $this->when($isProductShow, $price),
// 'discountPrice'           => $discountPrice,
// 'subTotalPrice'           => $subTotal,
// 'percentageIVA'      => $this->when($isProductShow, $this->percentage_iva), // percentage discount
// 'percentageDiscount' => $this->when($isProductShow, $this->percentage_discount), // percentage discount

// 'products.(show|store|update)'
// 'products.show', 'products.store', 'products.update'
