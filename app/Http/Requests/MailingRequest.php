<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' =>  ['required', 'string', 'max:2000'],
            'token_id' =>  ['required', 'exists:chatapp_tokens,id'],
            'phones' => ['required', 'array']
        ];
    }
}
