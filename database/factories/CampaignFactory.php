<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Models\Campaign;
use LaravelCompany\Mail\Models\CampaignStatus;
use LaravelCompany\Mail\Models\EmailService;
use LaravelCompany\Mail\Models\Template;

class CampaignFactory extends Factory
{
    /** @var string */
    protected $model = Campaign::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'workspace_id' => LaravelMail::currentWorkspaceId(),
            'subject' => $this->faker->title(),
            'from_name' => $this->faker->name(),
            'from_email' => $this->faker->email(),
            'email_service_id' => EmailService::factory(),
            'is_open_tracking' => true,
            'is_click_tracking' => true,
        ];
    }

    public function withContent(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'content' => $this->faker->paragraph(),
            ];
        });
    }

    public function withTemplate(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'template_id' => Template::factory(),
            ];
        });
    }

    public function draft(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => CampaignStatus::STATUS_DRAFT,
            ];
        });
    }

    public function queued(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => CampaignStatus::STATUS_QUEUED,
            ];
        });
    }

    public function sending(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => CampaignStatus::STATUS_SENDING,
            ];
        });
    }

    public function sent(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => CampaignStatus::STATUS_SENT,
            ];
        });
    }

    public function cancelled(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => CampaignStatus::STATUS_CANCELLED,
            ];
        });
    }

    public function withoutOpenTracking(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_open_tracking' => false,
            ];
        });
    }

    public function withoutClickTracking(): CampaignFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_click_tracking' => false,
            ];
        });
    }
}
