<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Models\EmailService;
use LaravelCompany\Mail\Models\EmailServiceType;

class EmailServiceFactory extends Factory
{
    /** @var string */
    protected $model = EmailService::class;

    public function definition(): array
    {
        return [
            'name' => ucwords($this->faker->word()),
            'workspace_id' => LaravelMail::currentWorkspaceId(),
            'type_id' => $this->faker->randomElement(EmailServiceType::pluck('id')),
            'settings' => ['foo' => 'bar'],
        ];
    }
}
