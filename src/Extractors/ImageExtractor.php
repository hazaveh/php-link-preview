<?php

namespace Hazaveh\LinkPreview\Extractors;

use Hazaveh\LinkPreview\Contracts\ExtractorInterface;
use Hazaveh\LinkPreview\Traits\CanExtractBySelector;
use Symfony\Component\DomCrawler\Crawler;

class ImageExtractor implements ExtractorInterface
{
    use CanExtractBySelector;
    private static array $selectors = [
        ['selector' => 'meta[property="twitter:image"]', 'attribute' => 'content'],
        ['selector' => 'meta[property="og:image"]', 'attribute' => 'content'],
        ['selector' => 'meta[itemprop="image"]', 'attribute' => 'content'],
    ];

    public static function extract(Crawler $crawler): string
    {
        return self::extractSelectors($crawler);
    }

    public static function name(): string
    {
        return 'image';
    }
}
