<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payload'     => 'required|json',
            'employee_id' => 'required',
            'password'    => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee id field is required in payload',
            'password.required'    => 'Password field is required in payload'
        ];
    }

    public function getValidatorInstance()
    {
        $payload = json_decode($this->payload, true);
        $this->merge($payload);

        return parent::getValidatorInstance();
    }
}
