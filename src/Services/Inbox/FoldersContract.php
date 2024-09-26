<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Services\Inbox;

use Illuminate\Support\Collection;

interface FoldersContract
{
    public function getFolders():Collection;
}
