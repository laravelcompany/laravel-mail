<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Models\Subscriber;

class SubscriberFactory extends Factory
{
    /** @var string */
    protected $model = Subscriber::class;

    public function definition(): array
    {
        return [
            'workspace_id' => LaravelMail::currentWorkspaceId(),
            'hash' => $this->faker->uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail()
        ];
    }
}
