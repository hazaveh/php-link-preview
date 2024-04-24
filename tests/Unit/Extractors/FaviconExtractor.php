<?php

use GuzzleHttp\Psr7\Response;

test('it handles relative path', function () {
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: '<!DOCTYPE html><html><head><link rel="icon" href="/favicon.ico"></head><body></body></html>')
    ]);

    $link = $parser->parse('https://hazaveh.net');

    expect($link->icon)->toBe('https://hazaveh.net/favicon.ico');
});

test('it handles absolute path', function () {
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: '<!DOCTYPE html><html><head><link rel="icon" href="https://hazaveh.net/favicon.ico"></head><body></body></html>')
    ]);

    $link = $parser->parse('https://hazaveh.net');

    expect($link->icon)->toBe('https://hazaveh.net/favicon.ico');
});

test('it handles trailing slashes', function () {
    $parser = $this->createSiteParserWithMockFakeHttpClient([
        new Response(body: '<!DOCTYPE html><html><head><link rel="icon" href="/favicon.ico"></head><body></body></html>')
    ]);

    $link = $parser->parse('https://hazaveh.net/');

    expect($link->icon)->toBe('https://hazaveh.net/favicon.ico');
});
