<?php

namespace LaravelCompany\Mail\Tasks;

class SaveModel extends Task
{
    public static array $fields = [
        'Model' => 'model',
    ];

    public static array $output = [
        'Output' => 'output',
    ];

    public static $icon = '<i class="fas fa-database"></i>';

    public function execute(): void
    {
        $model = $this->getData('model');

        $model->save();

        $this->setData('output', $model);
    }
}
