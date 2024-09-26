<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Services\Campaigns;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use LaravelCompany\Mail\Models\Campaign;
use LaravelCompany\Mail\Repositories\Campaigns\CampaignTenantRepositoryInterface;

class CampaignStatisticsService
{
    /**
     * @var CampaignTenantRepositoryInterface
     */
    protected $campaigns;

    public function __construct(CampaignTenantRepositoryInterface $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * @throws Exception
     */
    public function getForCampaign(Campaign $campaign, int $workspaceId): Collection
    {
        return $this->get(collect([$campaign]), $workspaceId);
    }

    /**
     * @throws Exception
     */
    public function getForCollection(Collection $campaigns, int $workspaceId): Collection
    {
        return $this->get($campaigns, $workspaceId);
    }

    /**
     * @throws Exception
     */
    public function getForPaginator(LengthAwarePaginator $paginator, int $workspaceId): Collection
    {
        return $this->get(collect($paginator->items()), $workspaceId);
    }

    /**
     * @throws Exception
     */
    protected function get(Collection $campaigns, int $workspaceId): Collection
    {
        $countData = $this->campaigns->getCounts($campaigns->pluck('id'), $workspaceId);

        return $campaigns->map(function (Campaign $campaign) use ($countData) {
            return [
                'campaign_id' => $campaign->id,
                'counts' => [
                    'total' => $countData[$campaign->id]->total,
                    'open' => $countData[$campaign->id]->opened,
                    'click' => $countData[$campaign->id]->clicked,
                    'sent' => $countData[$campaign->id]->sent,
                ],
                'ratios' => [
                    'open' => $campaign->getActionRatio($countData[$campaign->id]->opened, $countData[$campaign->id]->sent),
                    'click' => $campaign->getActionRatio($countData[$campaign->id]->clicked, $countData[$campaign->id]->sent),
                ],
            ];
        })->keyBy('campaign_id');
    }
}
