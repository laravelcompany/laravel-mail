<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Interfaces;

use LaravelCompany\Mail\Models\EmailService;

interface QuotaServiceInterface
{
    public function exceedsQuota(EmailService $emailService, int $messageCount): bool;
}
