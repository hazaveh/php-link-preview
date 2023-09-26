<?php

namespace Hazaveh\LinkPreview\Extractors;

use Hazaveh\LinkPreview\Contracts\ExtractorInterface;
use Hazaveh\LinkPreview\Traits\CanExtractBySelector;
use Symfony\Component\DomCrawler\Crawler;

class LocaleExtractor implements ExtractorInterface
{
    use CanExtractBySelector;
    private static array $selectors = [
        ['selector' => 'html', 'attribute' => 'lang'],
    ];

    public static function extract(Crawler $crawler): string
    {
        return self::extractSelectors($crawler);
    }

    public static function name(): string
    {
        return 'locale';
    }
}
