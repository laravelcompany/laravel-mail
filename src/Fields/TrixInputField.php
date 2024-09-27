<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Fields;

use LaravelCompany\Mail\DataBuses\DataBusResource;
use LaravelCompany\Mail\DataBuses\ModelResource;

class TrixInputField implements FieldInterface
{
    public $options;

    public function __construct()
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public function render(mixed $element, mixed $value, mixed $field): string
    {
        $placeholders = [];

        $placeholders['data_bus'] = DataBusResource::getValues($element, $value, $field);

        foreach ($placeholders['data_bus'] as $dataBusKey => $dataBusValue) {
            $placeholders['data_bus'][$dataBusKey] = '$dataBus->get(\\\''.$dataBusValue.'\\\')';
        }

        $placeholders['model'] = ModelResource::getValues($element, $value, $field);
        foreach ($placeholders['model'] as $modelKey => $modelValue) {
            $placeholders['model'][$modelKey] = '$model->'.$modelValue;
        }

        return view('laravel-mail::workflows.fields.trix_input_field', [
            'field' => $field,
            'value' => $value,
            'placeholders' => $placeholders,
        ])->render();
    }
}
