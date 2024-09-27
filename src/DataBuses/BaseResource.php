<?php

namespace LaravelCompany\Mail\DataBuses;

use Illuminate\Database\Eloquent\Model;

class BaseResource implements Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus)
    {
        return config($value);
    }

    public static function getValues(Model $element, mixed $value, mixed $field)
    {
        return [];
    }

    public static function loadResourceIntelligence(Model $element, $value, $field)
    {
        if ($element->inputField($field)) {
            return $element->inputField($field)->render($field, $value);
        }

        return view('workflows::fields.text_field', [
            'value' => $value,
            'field' => $field,
        ])->render();
    }
}
