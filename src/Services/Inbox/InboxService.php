<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Services\Inbox;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Webklex\PHPIMAP\Exceptions\GetMessagesFailedException;
use Webklex\PHPIMAP\Exceptions\ImapBadRequestException;
use Webklex\PHPIMAP\Exceptions\ImapServerErrorException;
use Webklex\PHPIMAP\Exceptions\ResponseException;
use Webklex\PHPIMAP\Exceptions\RuntimeException;
use Webklex\PHPIMAP\Support\FolderCollection;

class InboxService implements InboxContract
{
    private int $cacheTTL = 60; // Cache time in seconds (60 = 1 min)
    private mixed $client;

    /**
     * InboxService constructor.
     */
    public function __construct()
    {
        $this->client = \Webklex\IMAP\Facades\Client::account('default');
        $this->client->connect();
    }

    /**
     * Get IMAP folders and cache the result.
     *
     * @return FolderCollection
     */
    public function getFolders(): FolderCollection
    {
        return Cache::remember('imap_folders', $this->cacheTTL, function () {
            return $this->client->getFolders();
        });
    }


    /**
     * @throws RuntimeException
     * @throws ResponseException
     * @throws ImapServerErrorException
     * @throws GetMessagesFailedException
     * @throws FolderFetchingException
     * @throws ImapBadRequestException
     * @throws ConnectionFailedException
     * @throws AuthFailedException
     */
    public function getMessages(string $folder): Collection
    {
        $folders = $this->client->getFolders();

        $messagesCollection = collect();

        // Loop through each folder
        foreach ($folders as $imapFolder) {
            if ($imapFolder->name === $folder) {
                // Get all messages of the current mailbox
                $messages = $imapFolder->messages()->all()->get();

                // Process each message
                foreach ($messages as $message) {
                    $messagesCollection->push([
                        'uid' => $message->getUid(),
                        'subject' => $message->getSubject(),
                        'date' => $message->getDate(),
                        'body' => $message->getHTMLBody()
                    ]);
                }
            }
        }

        return $messagesCollection;
    }
}
