<?php

namespace Hazaveh\LinkPreview\Contracts;

use Symfony\Component\DomCrawler\Crawler;

interface ExtractorInterface
{
    public static function extract(Crawler $crawler): string;

    public static function name(): string;
}
