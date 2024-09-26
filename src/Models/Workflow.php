<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workflow extends Model
{
    private array $data = []; // Explicit property type

    protected $table = 'workflows';

    protected  $fillable = [
        'name',
    ];

    /**
     * Get the tasks associated with the workflow.
     *
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(\LaravelCompany\Mail\Tasks\Task::class);
    }

    /**
     * Get the triggers associated with the workflow.
     *
     * @return HasMany
     */
    public function triggers(): HasMany
    {
        return $this->hasMany(\LaravelCompany\Mail\Triggers\Trigger::class);
    }

    /**
     * Get the logs associated with the workflow.
     *
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(\LaravelCompany\Mail\Loggers\WorkflowLog::class);
    }

    /**
     * Get a trigger by its class type.
     *
     * @param string $class
     * @return Model|null
     */
    public function getTriggerByClass(string $class): ?Model
    {
        return $this->triggers()->where('type', $class)->first();
    }
}
