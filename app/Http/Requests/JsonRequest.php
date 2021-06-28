<?php


namespace App\Http\Requests;


use App\Exceptions\RequestValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class JsonRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @throws RequestValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new RequestValidationException(response()->json(['errors' => $errors], Response::HTTP_BAD_REQUEST));
    }
}