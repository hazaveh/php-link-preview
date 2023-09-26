<?php

namespace Hazaveh\LinkPreview\Contracts;

use Hazaveh\LinkPreview\Model\Link;

interface ParserInterface
{
    public function parse(string $url): Link;
}
