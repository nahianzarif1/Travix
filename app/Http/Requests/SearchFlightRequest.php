<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchFlightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => 'required|string',
            'to' => 'required|string|different:from',
            'departure' => 'required|date',
            'return' => 'nullable|date|after_or_equal:departure',
            'passengers' => 'required|integer|min:1',
            'tripType' => 'required|in:one-way,round-trip',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->route('home')->withErrors($validator)->withInput()->withFragment('flights')
        );
    }
}