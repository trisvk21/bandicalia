<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'username'      => ['nullable', 'string', 'max:50', Rule::unique(User::class)->ignore($this->user()->id)],
            'full_name'     => ['nullable', 'string', 'max:255'],
            'city'          => ['nullable', 'string', 'max:100'],
            'bio'           => ['nullable', 'string', 'max:1000'],
            'age'           => ['nullable', 'integer', 'min:14', 'max:100'],
            'general_level' => ['nullable', 'integer', 'min:1', 'max:5'],
            'has_band'      => ['nullable', 'boolean'],
            'photo'         => ['nullable', 'image', 'max:2048'],
            'genres'        => ['nullable', 'array'],
            'genres.*'      => ['exists:genres,id'],
            'instruments'   => ['nullable', 'array'],
            'instruments.*' => ['integer', 'min:1', 'max:5'],
            'account_type'   => ['nullable', 'in:musician,band'],
            'soundcloud_url' => ['nullable', 'url', 'max:255'],
            'spotify_url'    => ['nullable', 'url', 'max:255'],
        ];
    }
}