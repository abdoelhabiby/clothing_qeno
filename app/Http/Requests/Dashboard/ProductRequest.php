<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Support\Str;
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
        $rules = [
        "slug" => "required|string|" . Rule::unique('products', 'slug')->ignore($this->product),
        "sku" =>   "required|string|min:3|max:180|" . Rule::unique('products', 'sku')->ignore($this->product),
        "name" =>   "required|string|min:3|max:180",
        "image" => "sometimes|nullable|image|mimes:png,jpg,jpeg|max:2048",
        "is_active" => "sometimes|nullable",
        "categories" => 'sometimes|nullable|array|min:1',
        "categories.*" => "numeric|exists:categories,id",
        "quantity" => "required|numeric",
        "price" => "required|numeric"
        ];



    return $rules;

    }



    public function attributes()
    {
        return [
            "categories.*" => 'categories',
        ];
    }


    protected function prepareForValidation()
    {
        if ($this->has('slug')) {

            $slug = Str::slug($this->request->get('slug'));

            $this->merge([
                'slug' => $slug
            ]);
        }
    }


}
