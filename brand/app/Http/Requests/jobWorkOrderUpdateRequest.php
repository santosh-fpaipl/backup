<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class jobWorkOrderUpdateRequest extends FormRequest
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
            'quantities' => [$this->getQuantitiesValidationRule(), 'array'],
            'quantities.*' => ['integer', 'min:1'],
            'delivery_date' => 'nullable|date_format:Y-m-d',
            'status' => [$this->getStatusValidationRule(),'in:cancelled'],
        ];
    }

    /**
     * Get the validation rule for the 'status' field based on the provided inputs.
     *
     * @return array|string
     */
    private function getQuantitiesValidationRule()
    {
        // If 'delivery_date' & 'quantities' are provided, 'status' is not required
        if ($this->input('status')) {
            return 'nullable';
        } else {
            return 'required';
        }
    }

    private function getStatusValidationRule()
    {
        // If 'delivery_date' & 'quantities' are provided, 'status' is not required
        if ($this->input('delivery_date') && $this->input('quantities')) {
            return 'nullable';
        } else {
            return 'required';
        }
    }
}
