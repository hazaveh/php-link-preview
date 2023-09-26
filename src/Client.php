<?php

namespace Hazaveh\LinkPreview;

use GuzzleHttp\Exception\GuzzleException;
use Hazaveh\LinkPreview\Contracts\ParserInterface;
use Hazaveh\LinkPreview\Exceptions\InvalidURLException;
use Hazaveh\LinkPreview\Model\Link;
use Hazaveh\LinkPreview\Parsers\SiteParser;

class Client
{
    public readonly ParserInterface $parser;

    public function __construct(?ParserInterface $parser = null)
    {
        if ($parser) {
            $this->parser = $parser;
            return;
        }
        $this->parser = new SiteParser();
    }

    /**
     * @throws InvalidURLException
     */
    public function parse(string $url): Link
    {
        return $this->parser->parse($url);
    }
}
