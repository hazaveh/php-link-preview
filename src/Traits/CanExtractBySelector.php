<?php

namespace Hazaveh\LinkPreview\Traits;

use Symfony\Component\DomCrawler\Crawler;

trait CanExtractBySelector
{
    public static function extractSelectors(Crawler $crawler): string
    {
        $data = [];

        foreach (self::$selectors as $selector) {
            if($crawler->filter($selector['selector'])->count() > 0) {
                $data[] = isset($selector['attribute'])
                    ? $crawler->filter($selector['selector'])->first()->attr($selector['attribute'])
                    : $crawler->filter($selector['selector'])->first()->text();
            }
        }

        return count($data) ? $data[0] : "";
    }
}
