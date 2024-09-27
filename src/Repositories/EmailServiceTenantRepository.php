<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Repositories;

use LaravelCompany\Mail\Models\EmailService;
use LaravelCompany\Mail\Models\EmailServiceType;

class EmailServiceTenantRepository extends BaseTenantRepository
{
    /**
     * @var string
     */
    protected $modelName = EmailService::class;

    /**
     * @return mixed
     */
    public function getEmailServiceTypes()
    {
        return EmailServiceType::orderBy('name')->get();
    }

    /**
     * @param $emailServiceTypeId
     * @return mixed
     */
    public function findType($emailServiceTypeId)
    {
        return EmailServiceType::findOrFail($emailServiceTypeId);
    }

    /**
     * @param $emailServiceTypeId
     * @return array
     */
    public function findSettings($emailServiceTypeId)
    {
        if ($emailService = EmailService::where('type_id', $emailServiceTypeId)->first()) {
            return $emailService->settings;
        }

        return [];
    }
}
