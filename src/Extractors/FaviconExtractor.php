<?php

namespace Hazaveh\LinkPreview\Extractors;

use Hazaveh\LinkPreview\Contracts\ExtractorInterface;
use Hazaveh\LinkPreview\Traits\CanExtractBySelector;
use Symfony\Component\DomCrawler\Crawler;

class FaviconExtractor implements ExtractorInterface
{
    use CanExtractBySelector;

    /**
     * @var array<array<string, string>> $selectors
     */
    private static array $selectors = [
        ['selector' => 'link[rel="icon"]', 'attribute' => 'href']
    ];

    public static function extract(Crawler $crawler): string
    {
        $icon = self::extractSelectors($crawler);
        // If the icon is a relative path, we need to convert it to an absolute path
        if (strpos($icon, 'http') !== 0) {
            $icon = $crawler->getUri() . $icon;
        }
        return preg_replace('/([^:])(\\/{2,})/', '$1/', $icon);
    }

    public static function name(): string
    {
        return 'icon';
    }
}
