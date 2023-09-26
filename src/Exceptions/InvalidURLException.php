<?php

namespace Hazaveh\LinkPreview\Exceptions;

class InvalidURLException extends \Exception
{
    public function __construct(string $url)
    {
        parent::__construct(message: "$url is not a valid URL");
    }
}
