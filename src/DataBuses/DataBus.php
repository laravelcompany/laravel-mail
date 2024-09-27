<?php
declare(strict_types=1);

namespace LaravelCompany\Mail\DataBuses;

use Illuminate\Database\Eloquent\Model;
use LaravelCompany\Mail\DataBuses\ValueResource;
use ReflectionClass;
use Exception;

class DataBus
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collectData(Model $model, mixed $fields): void
    {

        $fieldsCollection = collect($fields)
            ->filter(function ($field, $name) {
                return $name !== 'description' && !($name === 'file' && empty($field['value']));
            });

        $fieldsCollection->each(function ($field, $name) use ($model) {
            $resourceClass = $field['type'] ?? ValueResource::class;

            try {
                $reflection = new ReflectionClass($resourceClass);

                if (!$reflection->isInstantiable() || !method_exists($resourceClass, 'getData')) {
                    throw new Exception("Class $resourceClass cannot be instantiated or does not have method getData.");
                }

                $resource = $reflection->newInstance();


                $this->data[$name] = $resource->getData($name, $field['value'] ?? '', $model, $this);

            } catch (Exception $e) {
                // Handle error (e.g., log the error)
                logger()->error($e->getMessage());
            }
        });
    }

    public function toString(): string
    {
        return implode("\n", $this->data);
    }

    public function get(string $key, string $default = null):mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function setOutput(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function setOutputArray(string $key, string $value): void
    {
        $this->data[$key][] = $value;
    }
}
