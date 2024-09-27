<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Adapters;

use LaravelCompany\Mail\Interfaces\MailAdapterInterface;

abstract class BaseMailAdapter implements MailAdapterInterface
{
    /** @var array */
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
