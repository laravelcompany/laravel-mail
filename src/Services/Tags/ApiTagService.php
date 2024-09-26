<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Services\Tags;

use Exception;
use Illuminate\Support\Collection;
use LaravelCompany\Mail\Models\Tag;
use LaravelCompany\Mail\Repositories\TagTenantRepository;

class ApiTagService
{
    /** @var TagTenantRepository */
    private TagTenantRepository $tags;

    public function __construct(TagTenantRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Store a new tag, optionally including attached subscribers.
     *
     * @throws Exception
     */
    public function store(int $workspaceId, Collection $data): Tag
    {
        $tag = $this->tags->store($workspaceId, $data->except('subscribers')->toArray());

        if (! empty($data['subscribers'])) {
            $tag->subscribers()->attach($data['subscribers']);
        }

        return $tag;
    }
}
