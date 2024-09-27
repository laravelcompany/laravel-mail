<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Pipelines\Campaigns;

use LaravelCompany\Mail\Models\Campaign;
use LaravelCompany\Mail\Models\CampaignStatus;

class StartCampaign
{
    /**
     * Mark the campaign as started in the database
     *
     * @param Campaign $campaign
     * @return Campaign
     */
    public function handle(Campaign $campaign, $next)
    {
        $this->markCampaignAsSending($campaign);

        return $next($campaign);
    }

    /**
     * Execute the database request
     *
     * @param Campaign $campaign
     * @return Campaign
     */
    protected function markCampaignAsSending(Campaign $campaign): ?Campaign
    {
        return tap($campaign)->update([
            'status_id' => CampaignStatus::STATUS_SENDING,
        ]);
    }
}
