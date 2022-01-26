<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GangaRequest extends FormRequest
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
        return [
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
            'points' => 'required',
            'img' => 'required',
            'price' => 'required',
            'discount_price' => 'required',
            'available' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'El nombre es obligatorio.',
            'description.required' => 'La description es obligatorio.',
            'url.required' => 'La url es obligatorio.',
            'points.required' => 'Los points es obligatorio.',
            'img.required' => 'La img es obligatorio.',
            'price.required' => 'El price es obligatorio.',
            'discount_price.required' => 'El discount_price es obligatorio.',
            'available.required' => 'Available es obligatorio.',
        ];
    }
}
