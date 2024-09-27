<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Campaigns;

use Exception;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Http\Requests\CampaignStoreRequest;
use LaravelCompany\Mail\Models\EmailService;
use LaravelCompany\Mail\Repositories\Campaigns\CampaignTenantRepositoryInterface;
use LaravelCompany\Mail\Repositories\EmailServiceTenantRepository;
use LaravelCompany\Mail\Repositories\Subscribers\SubscriberTenantRepositoryInterface;
use LaravelCompany\Mail\Repositories\TagTenantRepository;
use LaravelCompany\Mail\Repositories\TemplateTenantRepository;
use LaravelCompany\Mail\Services\Campaigns\CampaignStatisticsService;

class CampaignsController extends Controller
{
    /** @var CampaignTenantRepositoryInterface */
    protected $campaigns;

    /** @var TemplateTenantRepository */
    protected $templates;

    /** @var TagTenantRepository */
    protected $tags;

    /** @var EmailServiceTenantRepository */
    protected $emailServices;

    /** @var SubscriberTenantRepositoryInterface */
    protected $subscribers;

    /**
     * @var CampaignStatisticsService
     */
    protected $campaignStatisticsService;


    private int $workspaceId;

    public function __construct(
        CampaignTenantRepositoryInterface $campaigns,
        TemplateTenantRepository $templates,
        TagTenantRepository $tags,
        EmailServiceTenantRepository $emailServices,
        SubscriberTenantRepositoryInterface $subscribers,
        CampaignStatisticsService $campaignStatisticsService
    ) {
        $this->campaigns = $campaigns;
        $this->templates = $templates;
        $this->tags = $tags;
        $this->emailServices = $emailServices;
        $this->subscribers = $subscribers;
        $this->campaignStatisticsService = $campaignStatisticsService;


        $this->workspaceId = LaravelMail::currentWorkspaceId();
    }

    /**
     * @throws Exception
     */
    public function index(): ViewContract
    {
        $params = ['draft' => true];
        $campaigns = $this->campaigns->paginate($this->workspaceId, 'created_atDesc', ['status'], 25, $params);

        return view('laravel-mail::campaigns.index', [
            'campaigns' => $campaigns,
            'campaignStats' => $this->campaignStatisticsService->getForPaginator($campaigns, $this->workspaceId),
        ]);
    }

    /**
     * @throws Exception
     */
    public function sent(): ViewContract
    {
        $params = ['sent' => true];
        $campaigns = $this->campaigns->paginate($this->workspaceId, 'created_atDesc', ['status'], 25, $params);

        return view('laravel-mail::campaigns.index', [
            'campaigns' => $campaigns,
            'campaignStats' => $this->campaignStatisticsService->getForPaginator($campaigns, $this->workspaceId),
        ]);
    }

    /**
     * @throws Exception
     */
    public function create(): ViewContract
    {
        $templates = [null => '- None -'] + $this->templates->pluck($this->workspaceId);
        $emailServices = $this->emailServices->all($this->workspaceId, 'id', ['type'])
            ->map(static function (EmailService $emailService) {
                $emailService->formatted_name = "{$emailService->name} ({$emailService->type->name})";
                return $emailService;
            });

        return view('laravel-mail::campaigns.create', compact('templates', 'emailServices'));
    }

    /**
     * @throws Exception
     */
    public function store(CampaignStoreRequest $request): RedirectResponse
    {
        $campaign = $this->campaigns->store($this->workspaceId, $this->handleCheckboxes($request->validated()));

        return redirect()->route('laravel-mail.campaigns.preview', $campaign->id);
    }

    /**
     * @throws Exception
     */
    public function show(int $id): ViewContract
    {
        $campaign = $this->campaigns->find($this->workspaceId, $id);

        return view('laravel-mail::campaigns.show', compact('campaign'));
    }

    /**
     * @throws Exception
     */
    public function edit(int $id): ViewContract
    {
        $campaign = $this->campaigns->find($this->workspaceId, $id);
        $emailServices = $this->emailServices->all($this->workspaceId, 'id', ['type'])
            ->map(static function (EmailService $emailService) {
                $emailService->formatted_name = "{$emailService->name} ({$emailService->type->name})";
                return $emailService;
            });
        $templates = [null => '- None -'] + $this->templates->pluck($this->workspaceId);

        return view('laravel-mail::campaigns.edit', compact('campaign', 'emailServices', 'templates'));
    }

    /**
     * @throws Exception
     */
    public function update(int $campaignId, CampaignStoreRequest $request): RedirectResponse
    {
        $campaign = $this->campaigns->update(
            $this->workspaceId,
            $campaignId,
            $this->handleCheckboxes($request->validated())
        );

        return redirect()->route('laravel-mail.campaigns.preview', $campaign->id);
    }

    /**
     * @return RedirectResponse|ViewContract
     * @throws Exception
     */
    public function preview(int $id)
    {
        $campaign = $this->campaigns->find($this->workspaceId, $id);
        $subscriberCount = $this->subscribers->countActive($this->workspaceId);

        if (! $campaign->draft) {
            return redirect()->route('laravel-mail.campaigns.status', $id);
        }

        $tags = $this->tags->all($this->workspaceId, 'name');

        return view('laravel-mail::campaigns.preview', compact('campaign', 'tags', 'subscriberCount'));
    }

    /**
     * @return RedirectResponse|ViewContract
     * @throws Exception
     */
    public function status(int $id)
    {
        $campaign = $this->campaigns->find($this->workspaceId, $id, ['status']);

        if ($campaign->sent) {
            return redirect()->route('laravel-mail.campaigns.reports.index', $id);
        }

        return view('laravel-mail::campaigns.status', [
            'campaign' => $campaign,
            'campaignStats' => $this->campaignStatisticsService->getForCampaign($campaign, $this->workspaceId),
        ]);
    }

    /**
     * Handle checkbox fields.
     *
     * NOTE(david): this is here because the Campaign model is marked as being unable to use boolean fields.
     */
    private function handleCheckboxes(array $input): array
    {
        $checkboxFields = [
            'is_open_tracking',
            'is_click_tracking'
        ];

        foreach ($checkboxFields as $checkboxField) {
            if (! isset($input[$checkboxField])) {
                $input[$checkboxField] = false;
            }
        }

        return $input;
    }
}
