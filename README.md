<p align="center">  
  <img src="https://hazaveh.net/wp-content/uploads/php-link-preview.jpeg" />  
</p>  

# PHP Link Preview
PHP Link Preview is a small library that can crawl and return the OG & Meta tags of an URL. This can be used in your applications to display a preview of a URL similar to what happens when you paste a link in Social Media sites or Whatsapp.

### Current Information
* `title`: open graph title, if not found page title will be returned
* `description`: open graph description, if not found page description from meta tag is returned
* `image`: open graph image
* `icon`: favicon (if icon is explicitly specified in the HTML source)

## Dependencies
* PHP >= 8.2
* Guzzle >= 6
* Symfony DomCrawler >= 3.0
* Symfony CssSelector >= 3.0

## Installation
Simply run via composer:

    composer require hazaveh/php-link-preview

## Usage
Create an instance of Client and use `parse` method to crawl a URL.
```php
use Hazaveh\LinkPreview\Client;  
  
require_once 'vendor/autoload.php';  
  
$client = new Client();  

/**
* Returns an instance of Hazaveh\LinkPreview\Model\Link
* {title, description, image, icon, locale}
*/

$preview = $client->parse("https://hazaveh.net/2023/07/re-inventing-bookmarks-for-teams/");
```

## Using Custom Parser
Out of the box this library comes with a Parser that uses included extractor classes to extract different pieces of information from the page. You can always use a custom parser that implements `ParserInterface` and have your own logic to extract information from the page.

You are also free to use a Custom Link class which would then include additional information you might want to parse off the website during parsing process.

```php
class CustomParser implements ParserInterface  
{  
    public function parse(string $url): Link  
    {  
        return new Link(url: $url);  
    }  
}  
  
$client = new Client(new CustomParser());
```

## Contribution
Do something cool and add a PR.