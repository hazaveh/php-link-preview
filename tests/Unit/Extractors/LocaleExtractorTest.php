<?php

use GuzzleHttp\Psr7\Response;

use function PHPUnit\Framework\assertEquals;

test('it parses locale', function () {
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: '<!DOCTYPE html><html lang="en"><head></head><body></body></html>')
    ]);

    $link = $parser->parse('https://hazaveh.net');

    assertEquals("en", $link->locale);
});

test('it handle page without locale', function () {
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: '<!DOCTYPE html><html><head></head><body></body></html>')
    ]);

    $link = $parser->parse('https://hazaveh.net');

    assertEquals("", $link->locale);
});
