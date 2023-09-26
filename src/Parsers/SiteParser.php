<?php

namespace Hazaveh\LinkPreview\Parsers;

use GuzzleHttp\Client;
use Hazaveh\LinkPreview\Extractors\DescriptionExtractor;
use Hazaveh\LinkPreview\Extractors\ImageExtractor;
use Hazaveh\LinkPreview\Extractors\TitleExtractor;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Hazaveh\LinkPreview\Contracts\ParserInterface;
use Hazaveh\LinkPreview\Exceptions\InvalidURLException;
use Hazaveh\LinkPreview\Model\Link;
use Symfony\Component\DomCrawler\Crawler;

class SiteParser implements ParserInterface
{
    private ClientInterface $httpClient;

    private int $errorCode = 0;

    public function __construct()
    {

    }

    /**
     * @throws InvalidURLException
     */
    public function parse(string $url): Link
    {
        $this->validate($url);
        $html = $this->visit($url);

        if (! $html) {
            return new Link(url: $url, description: "Invalid response code {$this->errorCode}", error: $this->errorCode);
        }

        $data = $this->extractTags($html);

        return new Link($url, $data['title'], $data['description'], $data['image']);

    }

    private function visit(string $url): string | bool
    {

        try {
            $response = $this->client()->get($url);

            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return $response->getBody()->getContents();
            }
            $this->errorCode = $response->getStatusCode();
        } catch (GuzzleException $exception) {
            $this->errorCode = $exception->getCode();
        }

        return false;
    }

    /**
     * @param string $html
     * @return array{
     *     title: string,
     *     description: string,
     *     image: string
     * }
     */
    private function extractTags(string $html): array
    {

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $extracted = [];
        /**
         * @var ExtractorInterface $extractor
         */
        foreach ($this->getExtractors() as $extractor) {
            $extracted[$extractor::name()] = $extractor::extract($crawler);
        }

        return $extracted;

    }

    public function client(): Client
    {
        if (! $this->httpClient) {
            $this->httpClient = new Client(['http_errors' => false]);
        }

        return $this->httpClient;
    }

    /**
     * Use this method to explicitly pass your own instance of PSR-7 HTTP Client with Options.
     * @param ClientInterface $client
     * @return void
     */
    public function setClient(ClientInterface $client): void
    {
        $this->httpClient = $client;
    }

    /**
     * @throws InvalidURLException
     */
    public function validate(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidURLException($url);
        }
    }

    public function getExtractors(): array
    {
        return [
            TitleExtractor::name() => TitleExtractor::class,
            DescriptionExtractor::name() => DescriptionExtractor::class,
            ImageExtractor::name() => ImageExtractor::class
        ];
    }
}
