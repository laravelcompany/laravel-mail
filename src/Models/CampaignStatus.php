<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Models;

class CampaignStatus extends BaseModel
{
    //todo rename to sendportal_campaign_statuses
    protected $table = 'campaign_statuses';

    /** @var bool */
    public $timestamps = false;

    public const STATUS_DRAFT = 1;
    public const STATUS_QUEUED = 2;
    public const STATUS_SENDING = 3;
    public const STATUS_SENT = 4;
    public const STATUS_CANCELLED = 5;
}
