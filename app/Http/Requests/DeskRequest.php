<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeskRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:3',
            'position_x' => 'required|int',
            'position_y' => 'required|int',
        ];
    }
}
