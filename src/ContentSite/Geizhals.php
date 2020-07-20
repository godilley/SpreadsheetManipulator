<?php

namespace App\ContentSite;


class Geizhals extends ContentSite
{
    public function __construct()
    {
        $this
            ->configure(
                'geizhals.at',
                'https://geizhals.at',
                '/?fs=%s&hloc=at',
                'h1[itemprop="name"]'
            );
    }

    public function search($searchStr)
    {
        // TODO: Implement search() method.
    }
}
