<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Repositories;

use LaravelCompany\Mail\Models\Template;

class TemplateTenantRepository extends BaseTenantRepository
{
    protected $modelName = Template::class;
}
