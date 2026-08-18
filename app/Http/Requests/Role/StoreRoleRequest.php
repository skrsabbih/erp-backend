<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // validation rules for store role
            'name' => 'required, string, max:255, unique:roles,name',
            'permissions' => 'nullable, array',
            'permissions.*' => 'exists:permissions,name',

        ];
    }

    // custom message for validation errors
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            'name.unique' => 'Name must be unique',
            'permissions.array' => 'Permissions must be an array',
            'permissions.*.exists' => 'Permission does not exist',
        ];
    }
}
