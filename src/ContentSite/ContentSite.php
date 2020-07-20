<?php

namespace app\ContentSite;

abstract class ContentSite
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $name
     */
    protected $baseUrl;

    /**
     * @var string $name
     */
    protected $searchUri;

    /**
     * The setup function for basic information
     *
     * @param string $name
     * @param string $baseUrl
     * @param string $searchUri
     */
    protected function configure(string $name, string $baseUrl, string $searchUri)
    {
        $this->name = $name;
        $this->baseUrl = $baseUrl;
        $this->searchUri = $searchUri;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public function getSearchUri()
    {
        return $this->searchUri;
    }
}
