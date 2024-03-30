<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiderLocationHistoryStoreRequest extends FormRequest
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
            'rider_id' => 'required|integer',
            'service_name' => 'nullable|string|max:32',
            'latitude' => 'required|decimal:0,6',
            'longitude' => 'required|decimal:0,6',
            'capture_time' => 'required|date'
        ];
    }
}
