<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class UrlRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = Validator::make(['url' => $value], [
            'url' => 'url',
        ]);
    
        if ($validator->fails()) {
            $fail("The $attribute is invalid.");
            return;
        }

        $validator = Validator::make(['url' => $value], [
            'url' => ['required', 'url', 'regex:/^https:\/\/(www\.)?olx\.[a-z]{2,6}\/.*$/']
        ]);
        
        if ($validator->fails()) {
            $fail("The $attribute must be a valid OLX URL.");
            return;
        }
        
    
        $headers = @get_headers($value);
        if (!$headers || strpos($headers[0], '200') === false) {
            $fail("The $attribute is invalid.");
        }
    }
}
