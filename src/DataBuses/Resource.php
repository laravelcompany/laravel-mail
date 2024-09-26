<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\DataBuses;

use Illuminate\Database\Eloquent\Model;

interface Resource
{
    public function getData(string $name, string $value, Model $model, DataBus $dataBus);

    public static function getValues(Model $model, mixed $value, mixed$field_name);

    public static function loadResourceIntelligence(Model $element, mixed $value, mixed$field_name);
}
