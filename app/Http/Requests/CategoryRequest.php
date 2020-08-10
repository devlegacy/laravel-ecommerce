<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $category = $this->route('category');
        $unique = request()->routeIs('categories.update') ? Rule::unique('categories')->ignore($category->id) : Rule::unique('categories');

        return [
            'name'        => ['string', 'required', $unique],
            'description' => 'string',
        ];
    }
}
