<?php

namespace Hazaveh\LinkPreview\Extractors;

use Hazaveh\LinkPreview\Contracts\ExtractorInterface;
use Hazaveh\LinkPreview\Traits\CanExtractBySelector;
use Symfony\Component\DomCrawler\Crawler;

class DescriptionExtractor implements ExtractorInterface
{
    use CanExtractBySelector;

    /**
     * @var array<array<string, string>> $selectors
     */
    private static array $selectors = [
        ['selector' => 'meta[property="twitter:description"]', 'attribute' => 'content'],
        ['selector' => 'meta[property="og:description"]', 'attribute' => 'content'],
        ['selector' => 'meta[itemprop="description"]', 'attribute' => 'content'],
        ['selector' => 'meta[name="description"]', 'attribute' => 'content'],
    ];
    public static function extract(Crawler $crawler): string
    {
        return self::extractSelectors($crawler);
    }

    public static function name(): string
    {
        return "description";
    }
}
