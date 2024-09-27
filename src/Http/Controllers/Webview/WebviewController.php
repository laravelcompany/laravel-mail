<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Webview;

use Exception;
use Illuminate\Contracts\View\View as ViewContract;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Models\Message;
use LaravelCompany\Mail\Services\Content\MergeContentService;
use RuntimeException;

class WebviewController extends Controller
{
    /** @var MergeContentService */
    private $merger;

    public function __construct(MergeContentService $merger)
    {
        $this->merger = $merger;
    }

    /**
     * @throws Exception
     */
    public function show(string $messageHash): ViewContract
    {
        /** @var Message $message */
        $message = Message::with('subscriber')->where('hash', $messageHash)->first();

        if (! $message) {
            throw new RuntimeException('Message not found');
        }
        $content = $this->merger->handle($message);

        return view('laravel-mail::webview.show', compact('content'));
    }
}
