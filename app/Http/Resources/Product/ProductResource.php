<?php

namespace App\Http\Resources\Product;

use Picqer\Barcode\BarcodeGeneratorSVG;
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
        $price = $this->price; // total
        $discountPrice = $this->discount_price; // Real price
        $discount = $this->discount;
        $subTotal = $this->sub_total;
        $vat = $this->vat;

        $decimalDiscount = (float) bcdiv($this->discount_rate, 100, 2);
        $decimalVAT = (float) bcdiv($this->vat_rate, 100, 2);

        $reviews = request()->routeIs(...['products.show', 'products.store', 'products.update']);
        $isProductShow = request()->routeIs('products.show');
        $isProductIndex = request()->routeIs('products.index');

        $barcodeGeneratorSVG = new BarcodeGeneratorSVG();

        return [
            'id'          => $this->id,
            'category'    => $this->category->name,
            'barcode'     => $this->barcode,
            'name'        => $this->name,
            'description' => $this->description,
            'prices'      => [
                'subTotal' => $subTotal,
                'unit'     => $discountPrice,
                'discount' => $discountPrice,
                'total'    => $price,
            ],
            'taxes' => [
                'vat' => [ // iva
                    'rate'   => $decimalVAT,
                    'amount' => $vat, // impuesto $0.0 pesos | importe
                ],
            ],
            'discount'           => [
                'rate'   => $decimalDiscount,
                'amount' => $discount,  // ahorras $0.0 pesos | importe
            ],
            'stock'               => $this->stock === 0 ? 'Out of stock' : $this->stock,
            'images'              => ['product' => $this->image, 'barcode' => $this->barcode_svg],
            'rating'              => $this->reviews->count() > 0 ? bcdiv($this->reviews->sum('stars'), $this->reviews->count(), 2) : 'No rating yet',
            'isActive'            => $this->is_active,
            'href'                => [
                'reviews' => route('reviews.index', $this->id),
                'link'    => route('products.show', $this->id),
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
