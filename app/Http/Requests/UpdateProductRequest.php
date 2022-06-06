<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => 'image|max:15000|mimes:jpg,png,jpeg',
            'productSlider' => 'array',
            'productSlider.*' => 'image|mimes:jpg,png,jpeg|max:15000',
            'title' => 'required|max:100',
            'price' => 'required|numeric',
            'size'=> 'required|array',
            'description' => 'required|max:500',
            'category_id' => 'required|integer'
        ];
    }
}
