<?php

declare(strict_types=1);

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Models\Campaign;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CampaignsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function a_list_of_a_workspaces_campaigns_can_be_retrieved()
    {
        $emailService = $this->createEmailService();

        $campaign = $this->createCampaign($emailService);

        $this
            ->getJson(route('laravel-mail.api.campaigns.index'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    Arr::only($campaign->toArray(), ['name'])
                ]
            ]);
    }

    /** @test */
    public function a_single_campaign_can_be_retrieved()
    {
        $emailService = $this->createEmailService();

        $campaign = $this->createCampaign($emailService);

        $this
            ->getJson(route('laravel-mail.api.campaigns.show', [
                'campaign' => $campaign->id,
            ]))
            ->assertOk()
            ->assertJson([
                'data' => Arr::only($campaign->toArray(), ['name']),
            ]);
    }

    /** @test */
    public function a_new_campaign_can_be_added()
    {
        $emailService = $this->createEmailService();

        $request = [
            'name' => $this->faker->colorName(),
            'subject' => $this->faker->word(),
            'from_name' => $this->faker->word(),
            'from_email' => $this->faker->safeEmail(),
            'email_service_id' => $emailService->id,
            'content' => $this->faker->sentence(),
            'send_to_all' => 1,
            'scheduled_at' => now(),
        ];

        $this
            ->postJson(
                route('laravel-mail.api.campaigns.store'),
                $request
            )
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['data' => $request]);

        $this->assertDatabaseHas('campaigns', $request);
    }

    /** @test */
    public function a_campaign_can_be_updated()
    {
        $emailService = $this->createEmailService();

        $campaign = Campaign::factory()->draft()->create([
            'workspace_id' => LaravelMail::currentWorkspaceId(),
            'email_service_id' => $emailService->id,
        ]);

        $request = [
            'name' => $this->faker->word(),
            'subject' => $this->faker->word(),
            'from_name' => $this->faker->word(),
            'from_email' => $this->faker->safeEmail(),
            'email_service_id' => $emailService->id,
            'content' => $this->faker->sentence(),
            'send_to_all' => 1,
            'scheduled_at' => now(),
        ];

        $this
            ->putJson(route('laravel-mail.api.campaigns.update', [
                'campaign' => $campaign->id,
            ]), $request)
            ->assertOk()
            ->assertJson(['data' => $request]);

        $this->assertDatabaseMissing('campaigns', $campaign->toArray());
        $this->assertDatabaseHas('campaigns', $request);
    }

    /** @test */
    public function a_sent_campaign_cannot_be_updated()
    {
        $emailService = $this->createEmailService();

        $campaign = $this->createCampaign($emailService);

        $request = [
            'name' => $this->faker->word(),
            'subject' => $this->faker->word(),
            'from_name' => $this->faker->word(),
            'from_email' => $this->faker->safeEmail(),
            'email_service_id' => $emailService->id,
            'content' => $this->faker->sentence(),
            'send_to_all' => 1,
            'scheduled_at' => now(),
        ];

        $this
            ->putJson(route('laravel-mail.api.campaigns.update', [
                'campaign' => $campaign->id,
            ]), $request)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'status_id' => 'A campaign cannot be updated if its status is not draft'
            ]);

        $this->assertDatabaseMissing('campaigns', $request);
        self::assertEquals($campaign->updated_at, $campaign->fresh()->updated_at);
    }
}
