<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotEmpty implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $trimmed = trim(html_entity_decode(strip_tags($value)), "\t\n\r\0\x0B\xC2\xA0");

        return ! empty($trimmed);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The content field cannot be empty.';
    }
}
