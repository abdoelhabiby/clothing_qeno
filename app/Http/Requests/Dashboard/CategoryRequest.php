<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Support\Str;
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
        $rules = [
        "slug" => "required|string|" . Rule::unique('categories', 'slug')->ignore($this->category),
        "name" =>   "required|string|min:3|max:180|" . Rule::unique('categories', 'name')->ignore($this->category),
        "image" => "sometimes|nullable|image|mimes:png,jpg,jpeg|max:2048",
        "is_active" => "sometimes|nullable",


        ];



    return $rules;

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
