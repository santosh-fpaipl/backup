<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class jobWorkOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fabricator_id' => ['required', 'integer'],
            'product_id' => ['required', 'integer'],
            'quantities' => ['required', 'string'],
            //'quantities.*' => ['json'],
            'delivery_date' => 'required|date_format:Y-m-d',
        ];
    }
}
