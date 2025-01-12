<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'required|string|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
