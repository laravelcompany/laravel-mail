<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Http\Controllers\EmailServices;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use LaravelCompany\Mail\Facades\LaravelMail;
use LaravelCompany\Mail\Facades\Sendportal;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Http\Requests\EmailServiceTestRequest;
use LaravelCompany\Mail\Repositories\EmailServiceTenantRepository;
use LaravelCompany\Mail\Services\Messages\DispatchTestMessage;
use LaravelCompany\Mail\Services\Messages\MessageOptions;

class TestEmailServiceController extends Controller
{
    /** @var EmailServiceTenantRepository */
    private $emailServices;

    private int $workspaceId;

    public function __construct(EmailServiceTenantRepository $emailServices)
    {
        $this->emailServices = $emailServices;

        $this->workspaceId = LaravelMail::currentWorkspaceId();
    }

    /**
     * @throws Exception
     */
    public function create(int $emailServiceId): View
    {
        $emailService = $this->emailServices->find($this->workspaceId, $emailServiceId);

        return view('laravel-mail::email_services.test', compact('emailService'));
    }

    /**
     * @throws Exception
     */
    public function store(int $emailServiceId, EmailServiceTestRequest $request, DispatchTestMessage $dispatchTestMessage): RedirectResponse
    {
        $emailService = $this->emailServices->find($this->workspaceId, $emailServiceId);

        $options = new MessageOptions();
        $options->setFromEmail($request->input('from'));
        $options->setSubject($request->input('subject'));
        $options->setTo($request->input('to'));
        $options->setBody($request->input('body'));

        try {
            $messageId = $dispatchTestMessage->testService($this->workspaceId, $emailService, $options);

            if (! $messageId) {
                return redirect()
                    ->back()
                    ->with(['error', __('Failed to dispatch test email.')]);
            }

            return redirect()
                ->route('laravel-mail.email_services.index')
                ->with(['success' => __('The test email has been dispatched.')]);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Response: ' . $e->getMessage());
        }
    }
}
