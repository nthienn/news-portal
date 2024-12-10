<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdvertiseUpdateRequest extends FormRequest
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
            'top_bar_ad' => ['nullable', 'image', 'max:3000'],
            'top_bar_ad_url' => ['nullable', 'url'],
            'top_bar_ad_status' => ['boolean'],
            'middle_ad' => ['nullable', 'image', 'max:3000'],
            'middle_ad_url' => ['nullable', 'url'],
            'middle_ad_status' => ['boolean'],
            'bottom_bar_ad' => ['nullable', 'image', 'max:3000'],
            'bottom_bar_ad_url' => ['nullable', 'url'],
            'bottom_bar_ad_status' => ['boolean'],
            'sidebar_ad' => ['nullable', 'image', 'max:3000'],
            'sidebar_ad_url' => ['nullable', 'url'],
            'sidebar_ad_status' => ['boolean']
        ];
    }
}