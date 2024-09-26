<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Tags;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Http\Requests\TagStoreRequest;
use LaravelCompany\Mail\Http\Requests\TagUpdateRequest;
use LaravelCompany\Mail\Repositories\TagTenantRepository;

class TagsController extends Controller
{
    /** @var TagTenantRepository */
    private TagTenantRepository $tagRepository;

    private int $workspaceId;

    public function __construct(TagTenantRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;

        $this->workspaceId = LaravelMail::currentWorkspaceId();
    }

    /**
     * @throws Exception
     */
    public function index(): View
    {
        $tags = $this->tagRepository->paginate($this->workspaceId, 'name');

        return view('laravel-mail::tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('laravel-mail::tags.create');
    }

    /**
     * @throws Exception
     */
    public function store(TagStoreRequest $request): RedirectResponse
    {
        $this->tagRepository->store($this->workspaceId, $request->all());

        return redirect()->route('laravel-mail.tags.index');
    }

    /**
     * @throws Exception
     */
    public function edit(int $id): View
    {
        $tag = $this->tagRepository->find($this->workspaceId, $id, ['subscribers']);

        return view('laravel-mail::tags.edit', compact('tag'));
    }

    /**
     * @throws Exception
     */
    public function update(int $id, TagUpdateRequest $request): RedirectResponse
    {
        $this->tagRepository->update($this->workspaceId, $id, $request->all());

        return redirect()->route('laravel-mail.tags.index');
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->tagRepository->destroy($this->workspaceId, $id);

        return redirect()->route('laravel-mail.tags.index');
    }
}
