<?php

namespace LaravelCompany\Mail\Tasks;

use Illuminate\Support\Facades\Http;

class HttpStatus extends Task
{
    public static array $fields = [
        'Url' => 'url',
    ];

    public static array $output = [
        'HTTP Status' => 'http_status',
    ];

    public static $icon = '<i class="far fa-eye"></i>';

    public function execute(): void
    {
        $this->setData('http_status', Http::get($this->getData('url'))->status());
    }
}
