<?php

namespace LaravelCompany\Mail\Triggers;

use Illuminate\Database\Eloquent\Model;

trait WorkflowObservable
{
    public static function bootWorkflowObservable(): void
    {
        static::retrieved(function (Model $model) {
            self::startWorkflows($model, 'retrieved');
        });
        static::creating(function (Model $model) {
            self::startWorkflows($model, 'creating');
        });
        static::created(function (Model $model) {
            self::startWorkflows($model, 'created');
        });
        static::updating(function (Model $model) {
            self::startWorkflows($model, 'updating');
        });
        static::updated(function (Model $model) {
            self::startWorkflows($model, 'updated');
        });
        static::saving(function (Model $model) {
            self::startWorkflows($model, 'saving');
        });
        static::saved(function (Model $model) {
            self::startWorkflows($model, 'saved');
        });
        static::deleting(function (Model $model) {
            self::startWorkflows($model, 'deleting');
        });
        static::deleted(function (Model $model) {
            self::startWorkflows($model, 'deleted');
        });
    }

    public static function getRegisteredTriggers(string $class, string $event)
    {
        $class_array = explode('\\', $class);

        $className = $class_array[count($class_array) - 1];

        return Trigger::where('type', ObserverTrigger::class)
            ->where('data_fields->class->value', 'like', '%'.$className.'%')
            ->where('data_fields->event->value', $event)
            ->get();
    }

    public static function startWorkflows(Model $model, string $event)
    {
        if (! in_array($event, config('workflows.triggers.Observers.events'))) {
            return false;
        }

        foreach (self::getRegisteredTriggers(get_class($model), $event) as $trigger) {
            $trigger->start($model);
        }
    }
}
