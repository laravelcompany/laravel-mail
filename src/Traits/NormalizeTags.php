<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Traits;

trait NormalizeTags
{
    public function normalizeTags(string $content, string $tag): string
    {
        $search = [
            '{{ ' . $tag . ' }}',
            '{{' . $tag . ' }}',
            '{{ ' . $tag . '}}',
        ];

        return str_ireplace($search, '{{' . $tag . '}}', $content);
    }
}
