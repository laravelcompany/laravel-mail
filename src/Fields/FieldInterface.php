<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Fields;

interface FieldInterface
{
    public function render($element, $value, $field);
}
