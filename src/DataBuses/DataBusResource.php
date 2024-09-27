<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\DataBuses;

use Illuminate\Database\Eloquent\Model;

class DataBusResource implements Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus)
    {
        return $dataBus->data[$value];
    }

    public static function checkCondition(Model $element, DataBus $dataBus, string $field, string $operator, string $value)
    {
        switch ($operator) {
            case 'equal':
                return $dataBus->data[$dataBus->data[$field]] == $value;

            case 'not_equal':
                return $dataBus->data[$dataBus->data[$field]] != $value;

            default:
                return true;
        }
    }

    public static function getValues(Model $element, $value, $field)
    {
        return $element->getParentDataBusKeys();
    }

    public static function loadResourceIntelligence(Model $element, $value, $field)
    {
        $fields = self::getValues($element, $value, $field);

        return view('laravel-mail::workflows.fields.data_bus_resource_field', [
            'fields' => $fields,
            'value' => $value,
            'field' => $field,
        ])->render();
    }
}
