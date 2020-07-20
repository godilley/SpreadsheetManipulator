<?php

namespace app\ContentSite;

interface ContentSiteInterface
{
    /**
     * The setup function for basic information
     *
     * @param string $name
     * @param string $baseUrl
     * @param string $searchUri
     * @param string $filterPath
     */
    function configure(
        string $name,
        string $baseUrl,
        string $searchUri,
        string $filterPath
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
     * @param $searchStr
     * @return mixed
     */
    function search($searchStr);

    /**
     * Returns the full url
     *
     * @param $searchString
     * @return string
     */
    function getRequestUrl($searchString): string;

    function getFilterPath(): string;
}
