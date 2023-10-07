<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tag;

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

           $pattern = '/\p{L}+/u';
           preg_match_all($pattern, $value, $matches);
           $words = $matches[0];

          $words;
          $existingTags = Tag::whereIn('name', $words)->pluck('name')->toArray();

            //if($existingTags);
            if (empty($existingTags)) {
                return true; 
            } else {
                $validator->setCustomMessages([
                    'custom_validation' => 'наступні теги вже існують - '.$string1 = implode(', ', $existingTags)
                    ]);
            }

            return false; 


        });
    }


}
