<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class TheModelRequest extends FormRequest
{
    /**
     * Determine if the session is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->hasRole('super admin')) {
            return true;
        }
        switch ($this->method()) {
            case 'GET':
                return $this->user()->can('view the model');
                break;
            case 'POST':
                return $this->user()->can('create the model');
                break;
            case 'PUT':
            case 'PATCH':
                return $this->user()->can('update the model');
                break;
            case 'DELETE':
                return $this->user()->can('delete the model');
                break;
            default:
                return $this->user()->hasRole('super admin');
                break;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'column_one' => 'required',
        ];

        switch ($this->method()) {
            case 'POST':
                return array_merge($rules, [
                    'column_two' => 'required|unique:the_models',
                ]);
                break;
            case 'PUT':
            case 'PATCH':
                return array_merge($rules, [
                    'column_two' => 'required',
                ]);
                break;
            default:
                return $rules;
                break;
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'column_two.unique' => 'Column two must be unique.'
        ];
    }
}
