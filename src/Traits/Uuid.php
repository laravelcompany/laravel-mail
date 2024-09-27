<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Traits;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });
    }
}
