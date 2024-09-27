<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Http\Requests\Api\SubscriberTagDestroyRequest;
use LaravelCompany\Mail\Http\Requests\Api\SubscriberTagStoreRequest;
use LaravelCompany\Mail\Http\Requests\Api\SubscriberTagUpdateRequest;
use LaravelCompany\Mail\Http\Resources\Tag as TagResource;
use LaravelCompany\Mail\Repositories\Subscribers\SubscriberTenantRepositoryInterface;
use LaravelCompany\Mail\Services\Subscribers\Tags\ApiSubscriberTagService;

class SubscriberTagsController extends Controller
{
    /** @var SubscriberTenantRepositoryInterface */
    private $subscribers;

    /** @var ApiSubscriberTagService */
    private $apiService;

    public function __construct(
        SubscriberTenantRepositoryInterface $subscribers,
        ApiSubscriberTagService $apiService
    ) {
        $this->subscribers = $subscribers;
        $this->apiService = $apiService;
    }

    /**
     * @throws Exception
     */
    public function index(int $subscriberId): AnonymousResourceCollection
    {
        $workspaceId = LaravelMail::currentWorkspaceId();
        $subscriber = $this->subscribers->find($workspaceId, $subscriberId, ['tags']);

        return TagResource::collection($subscriber->tags);
    }

    /**
     * @throws Exception
     */
    public function store(SubscriberTagStoreRequest $request, int $subscriberId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = LaravelMail::currentWorkspaceId();
        $tags = $this->apiService->store($workspaceId, $subscriberId, collect($input['tags']));

        return TagResource::collection($tags);
    }

    /**
     * @throws Exception
     */
    public function update(SubscriberTagUpdateRequest $request, int $subscriberId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = LaravelMail::currentWorkspaceId();
        $tags = $this->apiService->update($workspaceId, $subscriberId, collect($input['tags']));

        return TagResource::collection($tags);
    }

    /**
     * @throws Exception
     */
    public function destroy(SubscriberTagDestroyRequest $request, int $subscriberId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = LaravelMail::currentWorkspaceId();
        $tags = $this->apiService->destroy($workspaceId, $subscriberId, collect($input['tags']));

        return TagResource::collection($tags);
    }
}
