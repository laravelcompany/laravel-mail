<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\DataBuses;

use LaravelCompany\Mail\Models\Workflow;
use Illuminate\Database\Eloquent\Model;

trait DataBussable
{
    /**
     * Define the relationship to the Workflow.
     */
    public function workflow(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * Get parent DataBus keys.
     *
     * @param array $passedFields
     * @return array
     */
    public function getParentDataBusKeys(array $passedFields = []): array
    {
        $newFields = $passedFields;

        if (!empty($this->parentable)) {
            foreach ($this->parentable::$output as $key => $value) {
                $fieldKey = sprintf(
                    '%s - %s - %s',
                    $this->parentable->name,
                    $key,
                    $this->parentable->getFieldValue($value)
                );
                $newFields[$fieldKey] = $this->parentable->getFieldValue($value);
            }

            $newFields = $this->parentable->getParentDataBusKeys($newFields);
        }

        return $newFields;
    }

    /**
     * Get data from the DataBus.
     *
     * @param string $value
     * @param string $default
     * @return mixed
     */
    public function getData(string $value, string $default = '')
    {
        return $this->dataBus->get($value, $default);
    }

    /**
     * Set data array in the DataBus.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setDataArray(string $key, $value): void
    {
        $this->dataBus->setOutputArray($key, $value);
    }

    /**
     * Set data in the DataBus.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setData(string $key, $value): void
    {
        $this->dataBus->setOutput($key, $value);
    }
}
