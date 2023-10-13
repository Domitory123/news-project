<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tag;

class NewsUpdateRequest extends FormRequest
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
            'file' => '',
            'id' => '',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->addExtension('custom_validation', function ($attribute, $value, $parameters, $validator) {
            // Ваша логіка валідації тут

        //    $pattern = '/\p{L}+/u';
        //    preg_match_all($pattern, $value, $matches);
        //    $words = $matches[0];

        $pattern = '/[^\p{L}\d]+/u'; 
        $words = preg_split($pattern, $value, -1, PREG_SPLIT_NO_EMPTY);
        
          $existingTags = Tag::whereIn('name', $words)
          ->whereNotIn('news_id', [$validator->getData()['id']])
          ->pluck('name')->toArray();

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
