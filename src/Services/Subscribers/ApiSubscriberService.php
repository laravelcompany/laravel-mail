<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Services\Subscribers;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelCompany\Mail\Events\SubscriberAddedEvent;
use LaravelCompany\Mail\Models\Subscriber;
use LaravelCompany\Mail\Repositories\Subscribers\SubscriberTenantRepositoryInterface;

class ApiSubscriberService
{
    /** @var SubscriberTenantRepositoryInterface */
    private SubscriberTenantRepositoryInterface $subscribers;

    public function __construct(SubscriberTenantRepositoryInterface $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    /**
     * The API provides the ability for the "store" endpoint to both create a new subscriber or update an existing
     * subscriber, using their email as the key. This method allows us to handle both scenarios.
     *
     * @throws Exception
     */
    public function storeOrUpdate(int $workspaceId, Collection $data): Subscriber
    {
        $existingSubscriber = $this->subscribers->findBy($workspaceId, 'email', $data['email']);

        if (! $existingSubscriber) {
            $subscriber = $this->subscribers->store($workspaceId, $data->toArray());

            event(new SubscriberAddedEvent($subscriber));

            return $subscriber;
        }

        return $this->subscribers->update($workspaceId, $existingSubscriber->id, $data->toArray());
    }

    public function delete(int $workspaceId, Subscriber $subscriber): bool
    {
        return DB::transaction(function () use ($workspaceId, $subscriber) {
            $subscriber->tags()->detach();
            return $this->subscribers->destroy($workspaceId, $subscriber->id);
        });
    }
}
