<?php

namespace App\ContentSite;

use App\Model\ContentFilterPath;

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
     * @var array
     */
    protected $contentFilterPaths = [];

    /**
     * @inheritDoc
     */
    public function configure(
        string $name,
        string $baseUrl,
        string $searchUri,
        array $contentFilterPaths
    ) {
        $this->name = $name;
        $this->baseUrl = $baseUrl;
        $this->searchUri = $searchUri;
        $this->contentFilterPaths = $contentFilterPaths;

        if (!is_array($this->contentFilterPaths)) {
            throw new \Exception('Invalid content filter paths type passed. Should be an array containing ContentFilterPath() objects');
        }

        foreach ($this->contentFilterPaths as $contentFilterPath) {
            if (!($contentFilterPath instanceof ContentFilterPath)) {
                throw new \Exception('Invalid content filter paths type passed. Should be an array containing ContentFilterPath() objects');
            }
        }
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
    public function getRequestUrl($searchString): string {
        return sprintf($this->getBaseUrl() . $this->getSearchUri(), $searchString);
    }

    /**
     * @inheritDoc
     */
    public function getContentFilterPaths(): array
    {
        return $this->contentFilterPaths;
    }
}
