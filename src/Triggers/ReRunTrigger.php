<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Triggers;

use LaravelCompany\Mail\Loggers\WorkflowLog;

class ReRunTrigger
{
    public static function startWorkflow(WorkflowLog $log)
    {
        $log->triggerable->start($log->elementable);
    }
}
