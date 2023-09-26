<?php

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Hazaveh\LinkPreview\Client;
use Hazaveh\LinkPreview\Contracts\ParserInterface;
use Hazaveh\LinkPreview\Model\Link;
use Hazaveh\LinkPreview\Parsers\SiteParser;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

test('it sets default parser if not defined', function () {
    $client = new Client();
    assertInstanceOf(SiteParser::class, $client->parser);
});

test('it accepts a custom parser', function () {
    class CustomParser implements ParserInterface
    {
        public function parse(string $url): Link
        {
            return new Link(url: $url);
        }
    }

    $client = new Client(new CustomParser());

    assertInstanceOf(CustomParser::class, $client->parser);
});

test('it can visit and parse a page', function () {
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: file_get_contents(\Pest\testDirectory('Stubs/response.html')))
    ]);

    $client = new Client($parser);

    $url = "https://hazaveh.net";
    $link = $client->parse($url);

    assertInstanceOf(Link::class, $link);

    assertEquals($url, $link->url);
});

test('it handles http errors', function () {
    $url = "https://hazaveh.net";

    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(404, ['Content-Length' => 0]),
        new RequestException('Error Communicating with Server', new Request('GET', $url))
    ]);

    $client = new Client($parser);

    $link = $client->parse($url);

    assertInstanceOf(Link::class, $link);

    assertEquals(404, $link->error);

    $link = $client->parse($url);

    assertEquals(0, $link->error);
});
