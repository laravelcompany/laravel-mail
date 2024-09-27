<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Services\Inbox;

use Illuminate\Support\Collection;

interface MessagesContract
{
    public function getMessages(string $folder): Collection;
}
