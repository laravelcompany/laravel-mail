<?php

namespace LaravelCompany\Mail\Triggers;

use LaravelCompany\Mail\Fields\DropdownField;

class ObserverTrigger extends Trigger
{
    public static $icon = '<i class="fas fa-binoculars"></i>';

    public static $fields = [
        'Class' => 'class',
        'Event' => 'event',
    ];

    public function inputFields(): array
    {
        return [
            'class' => DropdownField::make(config('workflows.triggers.Observers.classes')),
            'event' => DropdownField::make(array_combine(config('workflows.triggers.Observers.events'), config('workflows.triggers.Observers.events'))),
        ];

    }
}
