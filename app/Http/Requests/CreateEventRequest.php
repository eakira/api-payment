<?php

namespace App\Http\Requests;

class CreateEventRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:deposit,withdraw,transfer',
            'destination' => 'required|integer',
            'amount' => 'required|numeric',
            'origin' => 'integer|required_if:type,transfer'
        ];
    }

}
