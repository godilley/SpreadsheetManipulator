<?php

namespace app\ContentSite;

use App\Model\ContentFilterPath;

interface ContentSiteInterface
{
    /**
     * The setup function for basic information
     *
     * @param string $name
     * @param string $baseUrl
     * @param string $searchUri
     * @param array $contentFilterPaths
     *
     * @throws \Exception
     */
    function configure(
        string $name,
        string $baseUrl,
        string $searchUri,
        array $contentFilterPaths
    );

    /**
     * @return string
     */
    function getName(): string;

    /**
     * @return string
     */
    function getBaseUrl(): string;

    /**
     * @return string
     */
    function getSearchUri(): string;

    /**
     * Returns the full url
     *
     * @param $searchString
     * @return string
     */
    function getRequestUrl($searchString): string;

    /**
     * @return array|ContentFilterPath[]
     */
    function getContentFilterPaths(): array;
}
