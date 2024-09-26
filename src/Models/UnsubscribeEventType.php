<?php

namespace LaravelCompany\Mail\Models;

class UnsubscribeEventType extends BaseModel
{
    protected $table = 'unsubscribe_event_types';

    public const BOUNCE = 1;
    public const COMPLAINT = 2;
    public const MANUAL_BY_ADMIN = 3;
    public const MANUAL_BY_SUBSCRIBER = 4;

    public static $types = [
        1 => 'Bounced',
        2 => 'Complained',
        3 => 'Manual by Admin',
        4 => 'Manual by Subscriber',
        5 => 'Automated by Admin',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @param int $id
     * @return mixed
     */
    public static function findById($id): string
    {
        return \Arr::get(static::$types, $id);
    }
}
