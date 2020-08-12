<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the product "saving" event.
     *
     * @param  App\Models\Product $product
     * @return void
     */
    public function saving(Product $product)
    {
        // Calculate discount price
        $price = $product->price;
        $percentageDiscount = $product->discount_rate;
        $decimalDiscount = bcdiv($percentageDiscount, 100, 2);
        $discountPrice = bcmul(bcsub(1, $decimalDiscount, 2), $price, 4);
        $discount = bcsub($price, $discountPrice, 4);

        $decimalVAT = bcdiv($product->vat_rate, 100, 2);
        $subTotal = bcdiv($discountPrice, bcadd(1, $decimalVAT, 2), 4);
        $vat = bcsub($discountPrice, $subTotal, 4);

        $product->discount_price = $discountPrice;
        $product->discount = $discount;
        $product->sub_total = $subTotal;
        $product->vat = $vat;
    }

    /**
     * Handle the product "created" event.
     *
     * @param  App\Models\Product $product
     * @return void
     */
    public function created(Product $product)
    {
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  App\Models\Product $product
     * @return void
     */
    public function updated(Product $product)
    {
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  App\Models\Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  App\Models\Product $product
     * @return void
     */
    public function restored(Product $product)
    {
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  App\Models\Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
    }
}
