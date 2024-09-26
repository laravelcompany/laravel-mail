<?php

declare(strict_types=1);

namespace Tests;

use LaravelCompany\Mail\Facades\LaravelMail as Sendportal;
use LaravelCompany\Mail\Models\Campaign;
use LaravelCompany\Mail\Models\EmailService;
use LaravelCompany\Mail\Models\Subscriber;
use LaravelCompany\Mail\Models\Tag;

trait LaravelMailTestSupportTrait
{
    protected function createEmailService(): EmailService
    {
        return EmailService::factory()->create([
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]);
    }

    protected function createCampaign(EmailService $emailService): Campaign
    {
        return Campaign::factory()
            ->withContent()
            ->sent()
            ->create([
                'workspace_id' => Sendportal::currentWorkspaceId(),
                'email_service_id' => $emailService->id,
            ]);
    }

    protected function createTag(): Tag
    {
        return Tag::factory()->create([
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]);
    }

    protected function createSubscriber(): Subscriber
    {
        return Subscriber::factory()->create([
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]);
    }
}
