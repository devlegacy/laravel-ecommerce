<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categoryId = request()->input('category_id');
        $productNameStoreRule = request()->routeIs('products.store')
        ? ['required', Rule::unique('products', 'name')->where(fn ($query) => $query->where('category_id', $categoryId)), ]
        : [];

        return [
            'category_id'   => 'required|exists:categories,id',
            'name'          => [...$productNameStoreRule, 'max:100', ],
            'description',
            'image',
            'barcode'       => 'sometimes|unique:products,barcode',
            'price'         => 'required',
            'discount_rate',
            'vat_rate',
            'stock',
        ];
    }
}
