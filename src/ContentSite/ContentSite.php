<?php

namespace App\ContentSite;

abstract class ContentSite implements ContentSiteInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $searchUri;

    /**
     * @var string
     */
    protected $filterPath;

    /**
     * @inheritDoc
     */
    public function configure(
        string $name,
        string $baseUrl,
        string $searchUri,
        string $filterPath
    ) {
        $this->name = $name;
        $this->baseUrl = $baseUrl;
        $this->searchUri = $searchUri;
        $this->filterPath = $filterPath;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @inheritDoc
     */
    public function getSearchUri(): string
    {
        return $this->searchUri;
    }

    /**
     * @inheritDoc
     */
    abstract public function search($searchStr);

    /**
     * @inheritDoc
     */
    public function getRequestUrl($searchString): string {
        return sprintf($this->getBaseUrl() . $this->getSearchUri(), $searchString);
    }

    /**
     * @return string
     */
    public function getFilterPath(): string
    {
        return $this->filterPath;
    }
}
