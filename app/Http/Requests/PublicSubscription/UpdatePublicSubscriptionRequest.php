<?php

namespace App\Http\Requests\PublicSubscription;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePublicSubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'phone' => 'required',
            'birth' => 'required',
            'resident' => 'required',
            'fiscal_code' => 'required|size:16',
            'sub_token' => 'required',
            'postal_code' => 'string',
        ];
    }
}
