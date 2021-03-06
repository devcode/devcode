<?php

namespace App\Http\Requests;


use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|min:3',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'nama tidak boleh kosong',
            'email.required'    => 'email tidak boleh kosong',
            'password.required' => 'password tidak boleh kosong',
            'name.min'          => 'nama minimal 3 karakter',
            'email.email'       => 'email tidak valid',
            'email.unique'      => 'email sudah ada yang pakai',
            'password.min'      => 'password minimal 6 karakter'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'status' => 'fail',
            'errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
