<?php

namespace LaravelCompany\Mail\Repositories\Workflows;

use LaravelCompany\Mail\Loggers\WorkflowLog;
use LaravelCompany\Mail\Repositories\BaseEloquentRepository;

class WorkflowLogRepository extends BaseEloquentRepository
{
    protected $modelName = WorkflowLog::class;

}
