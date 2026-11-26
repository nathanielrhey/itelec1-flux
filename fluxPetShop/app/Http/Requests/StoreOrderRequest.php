<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (is_string($this->customer_name)) {
            $this->merge([
                'customer_name' => trim($this->customer_name),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'customer_name' => ['required', 'string', 'min:2', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }

    /**
     * Get custom validation messages for the order form.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a pet shop product to order.',
            'product_id.integer' => 'The selected product is invalid.',
            'product_id.exists' => 'The selected product could not be found.',
            'customer_name.required' => 'Please enter the customer name.',
            'customer_name.min' => 'Customer name must be at least 2 characters.',
            'customer_name.max' => 'Customer name cannot exceed 255 characters.',
            'quantity.required' => 'Please enter an order quantity.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'quantity.max' => 'Quantity cannot exceed 999 in a single order.',
        ];
    }
}
