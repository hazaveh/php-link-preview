<?php

use GuzzleHttp\Psr7\Response;
use Hazaveh\LinkPreview\Exceptions\InvalidURLException;

use function PHPUnit\Framework\assertEquals;

test('it validates urls', function () {
    $parser = new \Hazaveh\LinkPreview\Parsers\SiteParser();
    $parser->parse('http:/google.com');
})->expectException(InvalidURLException::class);

test('it can use a custom http client', function () {
    $httpClient = new \GuzzleHttp\Client();
    $parser = new \Hazaveh\LinkPreview\Parsers\SiteParser();
    $parser->setClient($httpClient);
    assertEquals($parser->client(), $httpClient);
});

test('it can parse correctly', function () {
    /** @var \Hazaveh\LinkPreview\Parsers\SiteParser $parser */
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: file_get_contents(\Pest\testDirectory('Stubs/response.html')))
    ]);

    $link = $parser->parse('https://hazaveh.net');

    assertEquals("Your Page Title", $link->title);
    assertEquals("Your page description goes here.", $link->description);
    assertEquals("https://example.com/your-image.jpg", $link->image);
});
