<?php

namespace Hazaveh\LinkPreview\Extractors;

use Hazaveh\LinkPreview\Contracts\ExtractorInterface;
use Hazaveh\LinkPreview\Traits\CanExtractBySelector;
use Symfony\Component\DomCrawler\Crawler;

class TitleExtractor implements ExtractorInterface
{
    use CanExtractBySelector;

    /**
     * @var array<array<string, string>> $selectors
     */
    private static array $selectors = [
        ['selector' => 'meta[property="twitter:title"]', 'attribute' => 'content'],
        ['selector' => 'meta[property="og:title"]', 'attribute' => 'content'],
        ['selector' => 'meta[itemprop="name"]', 'attribute' => 'content'],
        ['selector' => 'title']
    ];
    public static function extract(Crawler $crawler): string
    {
        return self::extractSelectors($crawler);
    }

    public static function name(): string
    {
        return 'title';
    }
}
