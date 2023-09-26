<?php

namespace Hazaveh\LinkPreview\Extractors;

use Hazaveh\LinkPreview\Contracts\ExtractorInterface;
use Hazaveh\LinkPreview\Traits\CanExtractBySelector;
use Symfony\Component\DomCrawler\Crawler;

class FaviconExtractor implements ExtractorInterface
{
    use CanExtractBySelector;
    private static array $selectors = [
        ['selector' => 'link[rel="icon"]', 'attribute' => 'href']
    ];

    public static function extract(Crawler $crawler): string
    {
        return self::extractSelectors($crawler);
    }

    public static function name(): string
    {
        return 'icon';
    }
}
