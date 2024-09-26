<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Http\Requests\TemplateStoreRequest;
use LaravelCompany\Mail\Http\Requests\TemplateUpdateRequest;
use LaravelCompany\Mail\Repositories\TemplateTenantRepository;
use LaravelCompany\Mail\Services\Templates\TemplateService;
use LaravelCompany\Mail\Traits\NormalizeTags;
use Throwable;

class TemplatesController extends Controller
{
    use NormalizeTags;

    /** @var TemplateTenantRepository */
    private $templates;

    /** @var TemplateService */
    private $service;

    private int $workspaceId;

    public function __construct(TemplateTenantRepository $templates, TemplateService $service)
    {
        $this->templates = $templates;
        $this->service = $service;

        $this->workspaceId = LaravelMail::currentWorkspaceId();
    }

    /**
     * @throws Exception
     */
    public function index(): View
    {
        $templates = $this->templates->paginate($this->workspaceId, 'name');

        return view('laravel-mail::templates.index', compact('templates'));
    }

    public function create(): View
    {
        return view('laravel-mail::templates.create');
    }

    /**
     * @throws Exception
     */
    public function store(TemplateStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->service->store($this->workspaceId, $data);

        return redirect()
            ->route('laravel-mail.templates.index');
    }

    /**
     * @throws Exception
     */
    public function edit(int $id): View
    {
        $template = $this->templates->find($this->workspaceId, $id);

        return view('laravel-mail::templates.edit', compact('template'));
    }

    /**
     * @throws Exception
     */
    public function update(TemplateUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $this->service->update($this->workspaceId, $id, $data);

        return redirect()
            ->route('laravel-mail.templates.index');
    }

    /**
     * @throws Throwable
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($this->workspaceId, $id);

        return redirect()
            ->route('laravel-mail.templates.index')
            ->with('success', __('Template successfully deleted.'));
    }
}
