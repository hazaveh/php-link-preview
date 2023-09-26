<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Hazaveh\LinkPreview\Parsers\SiteParser;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @param Response[] $responses
     * @return Client
     */
    public function createMockHttpClient(array $responses): Client
    {

        $handlerStack = HandlerStack::create((new MockHandler($responses)));

        return new Client(['handler' => $handlerStack, 'http_errors' => false]);

    }

    /**
     * @param Response[] $responses
     * @return SiteParser
     */
    public function createSiteParserWithMockFakeHttpClient(array $responses): SiteParser
    {
        $parser = new SiteParser();
        $parser->setClient($this->createMockHttpClient($responses));
        return $parser;
    }
}
