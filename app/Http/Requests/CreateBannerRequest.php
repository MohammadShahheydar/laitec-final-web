<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Hekmatinasser\Verta\Verta;

class CreateBannerRequest extends FormRequest
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
            'image' => 'required|image|max:15000|mimes:jpg,png,jpeg',
            'title' => 'required|string|max:200',
            'persianDatapicker' => 'required|jdatetime|jdatetime_after',
            'lastPrice' => 'required|numeric',
            'newPrice' => 'required|numeric|lower_than:lastPrice'
        ];
    }
}
