<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255',
            'text' => 'required|string',
            'tag' => 'required|string|custom_validation',
            'file' => 'required',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->addExtension('custom_validation', function ($attribute, $value, $parameters, $validator) {
            // Ваша логіка валідації тут
           // dd($value);


           $validator->setCustomMessages([
            'custom_validation' => 'Це поле повинно мати значення "some_expected_value".'
         ]);

           return false;
            
            return true; 


        });
    }


}
