<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Services\Content;

use Exception;
use LaravelCompany\Mail\Models\Campaign;
use LaravelCompany\Mail\Models\Message;
use LaravelCompany\Mail\Repositories\AutomationScheduleRepository;
use LaravelCompany\Mail\Repositories\Campaigns\CampaignTenantRepositoryInterface;
use LaravelCompany\Mail\Traits\NormalizeTags;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class MergeContentService
{
    use NormalizeTags;

    /** @var CampaignTenantRepositoryInterface */
    private CampaignTenantRepositoryInterface $campaignRepo;

    /** @var CssToInlineStyles */
    private CssToInlineStyles $cssProcessor;

    public function __construct(
        CampaignTenantRepositoryInterface $campaignRepo,
        CssToInlineStyles $cssProcessor
    ) {
        $this->campaignRepo = $campaignRepo;
        $this->cssProcessor = $cssProcessor;
    }

    /**
     * @throws Exception
     */
    public function handle(Message $message): string
    {
        return $this->inlineStyles($this->resolveContent($message));
    }

    /**
     * @throws Exception
     */
    protected function resolveContent(Message $message): string
    {
        if ($message->isCampaign()) {
            $mergedContent = $this->mergeCampaignContent($message);
        } elseif ($message->isAutomation()) {
            $mergedContent = $this->mergeAutomationContent($message);
        } else {
            throw new Exception('Invalid message source type for message id=' . $message->id);
        }

        return $this->mergeTags($mergedContent, $message);
    }

    /**
     * @throws Exception
     */
    private function mergeCampaignContent(Message $message): string
    {
        /** @var Campaign $campaign */
        $campaign = $this->campaignRepo->find($message->workspace_id, $message->source_id, ['template']);

        if (! $campaign) {
            throw new Exception('Unable to resolve campaign step for message id= ' . $message->id);
        }

        return $campaign->template
            ? $this->mergeContent($campaign->content, $campaign->template->content)
            : $campaign->content;
    }

    /**
     * @throws Exception
     */
    private function mergeAutomationContent(Message $message): string
    {
        if (! $schedule = app(AutomationScheduleRepository::class)->find($message->source_id, ['automation_step'])) {
            throw new Exception('Unable to resolve automation step for message id=' . $message->id);
        }

        if (! $content = $schedule->automation_step->content) {
            throw new Exception('Unable to resolve content for automation step id=' . $schedule->automation_step_id);
        }

        if (! $template = $schedule->automation_step->template) {
            throw new Exception('Unable to resolve template for automation step id=' . $schedule->automation_step_id);
        }

        return $this->mergeContent($content, $template->content);
    }

    private function mergeContent(?string $customContent, string $templateContent): string
    {
        return str_ireplace(['{{content}}', '{{ content }}'], $customContent ?: '', $templateContent);
    }

    private function mergeTags(string $content, Message $message): string
    {
        $content = $this->compileTags($content);

        $content = $this->mergeSubscriberTags($content, $message);
        $content = $this->mergeUnsubscribeLink($content, $message);
        return $this->mergeWebviewLink($content, $message);
    }

    private function compileTags(string $content): string
    {
        $tags = [
            'email',
            'first_name',
            'last_name',
            'meta',
            'unsubscribe_url',
            'webview_url',
            'tracking_url',
        ];

        foreach ($tags as $tag) {
            $content = $this->normalizeTags($content, $tag);
        }

        return $content;
    }

    private function mergeSubscriberTags(string $content, Message $message): string
    {
        $tags = [
            'email' => $message->recipient_email,
            'first_name' => optional($message->subscriber)->first_name ?? '{{first_name}}',
            'last_name' => optional($message->subscriber)->last_name ?? '{{last_name}}',
            'meta' => optional($message->subscriber)->meta ?? '{{meta}}',
        ];

        foreach ($tags as $key => $replace) {
            $content = str_ireplace('{{' . $key . '}}', $replace, $content);
        }

        return $content;
    }

    private function mergeUnsubscribeLink(string $content, Message $message): string
    {
        $unsubscribeLink = $this->generateUnsubscribeLink($message);

        return str_ireplace(['{{ unsubscribe_url }}', '{{unsubscribe_url}}'], $unsubscribeLink, $content);
    }

    private function generateUnsubscribeLink(Message $message): string
    {
        return route('laravel-mail.subscriptions.unsubscribe', $message->hash);
    }

    private function mergeWebviewLink(string $content, Message $message): string
    {
        $webviewLink = $this->generateWebviewLink($message);

        return str_ireplace('{{webview_url}}', $webviewLink, $content);
    }

    private function generateWebviewLink(Message $message): string
    {
        return route('laravel-mail.webview.show', $message->hash);
    }

    private function inlineStyles(string $content): string
    {
        return $this->cssProcessor->convert($content);
    }

    //todo add tracking image pixel here
}
