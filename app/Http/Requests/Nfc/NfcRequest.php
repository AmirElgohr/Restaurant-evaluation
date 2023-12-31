<?php

namespace App\Http\Requests\Nfc;

use Illuminate\Foundation\Http\FormRequest;

class NfcRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'restaurant_id' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'nfc_number' => 'required|numeric',
        ];
    }
}
