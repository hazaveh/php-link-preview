<?php

namespace Hazaveh\LinkPreview\Model;

class Link
{
    public function __construct(
        public readonly string $url,
        public readonly ?string $title = "",
        public readonly ?string $description  = "",
        public readonly ?string $image  = "",
        public readonly ?string $icon  = "",
        public readonly ?int $error  = 0,
        public readonly string $locale = "en_US",
    ) {
    }
}
