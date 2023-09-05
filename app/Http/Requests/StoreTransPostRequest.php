<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransPostRequest extends FormRequest
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
    public function rules()
    {
        return [

            'post_id' => [
                'integer',
                'required',
            ],
            'languages.*' => [
                'integer',
            ],
            'languages' => [
                'array',
            ],

            'title' => [
                'string',
                'required',
            ],
            'content' => [
                'string',
                'required',
            ],
            'publish_date' => [
                'date',
                'required',
            ],
            'publish_time' => [
                'nullable',

            ],
            'status' => [
                'boolean',
                'required',
            ],

        ];
    }
}
