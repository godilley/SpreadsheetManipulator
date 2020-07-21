<?php

namespace App\ContentSite;


use App\Model\ContentFilterPath;

class Geizhals extends ContentSite
{
    /**
     * Geizhals constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this
            ->configure(
                'geizhals.at',
                'https://geizhals.at',
                '/?fs=%s&hloc=at',
                [
                    new ContentFilterPath(ContentFilterPath::TYPE_CSS_SELECTOR, 'h1[itemprop="name"]', 500),
                    new ContentFilterPath(ContentFilterPath::TYPE_CSS_SELECTOR, '.cell.block-click.offer__details', 500),
                ]
            );
    }
}
