<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Http\Controllers\Inbox;

use Illuminate\View\View;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Services\Inbox\InboxService;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Webklex\PHPIMAP\Exceptions\GetMessagesFailedException;
use Webklex\PHPIMAP\Exceptions\ImapBadRequestException;
use Webklex\PHPIMAP\Exceptions\ImapServerErrorException;
use Webklex\PHPIMAP\Exceptions\ResponseException;
use Webklex\PHPIMAP\Exceptions\RuntimeException;


class InboxController extends Controller
{
    private InboxService $inboxService;

    public function __construct(InboxService $inboxService)
    {
        $this->inboxService = $inboxService;
    }


    /**
     * @throws RuntimeException
     * @throws ResponseException
     * @throws FolderFetchingException
     * @throws ImapBadRequestException
     * @throws ConnectionFailedException
     * @throws ImapServerErrorException
     * @throws AuthFailedException
     * @throws GetMessagesFailedException
     */
    public function index(): View
    {
        $messages = $this->inboxService->getMessages("INBOX");

        return view('laravel-mail::inbox.index', compact( 'messages'));
    }



    public function show(int $id)
    {
        return view('laravel-mail::inbox.show');
    }
}
