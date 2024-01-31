<?php

namespace App\Http\Requests\Admin\Admins;

use App\Models\Admins\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('edit', Admin::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'enabled' => 'nullable|boolean',
            'role_id' => 'required',
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'required|email|unique:' . config('akawam.database.table_prefix') . 'admins,email,' . $this->id,
            'avatar' => 'sometimes|file|mimetypes:image/jpeg,image/png|max:5000',
            'password' => ['nullable', 'min:8', 'max:255', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!"#$%&()*+,-.:;<=>?@[\]\\\\^_`{|}~]/'],
        ];

        if ($this->filled('password')) {
            $rules['password'][] = 'required';
        }

        return $rules;
    }
}
