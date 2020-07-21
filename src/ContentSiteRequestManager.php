<?php

namespace App;

use App\ContentSite\ContentSiteInterface;
use App\Model\ContentFilterPath;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class ContentSiteRequestManager extends RequestManager
{
    /**
     * @param ContentSiteInterface $contentSite
     * @param string $searchStr
     * @param null $syncResultValidator
     * @return string|array|null - Returns array if no syncResultValidator provided OR string if not - If not found null
     */
    public function searchSite(ContentSiteInterface $contentSite, string $searchStr, $syncResultValidator = null)
    {
        $results = [];
        try {
            $request =  $this->doGetRequest($contentSite->getRequestUrl($searchStr));

            if ($request->getStatusCode() !== 200) {
                return null;
            }

            $body = $request->getBody()->getContents();
            $crawler = new Crawler($body);
            $filterPaths = $contentSite->getContentFilterPaths();

            foreach ($filterPaths as $contentFilterPath) {
                try {
                    switch ($contentFilterPath->getType()) {
                        case ContentFilterPath::TYPE_CSS_SELECTOR:
                            $text = $crawler->filter($contentFilterPath->getPath())->text();
                            break;
                        case ContentFilterPath::TYPE_XPATH_SELECTOR:
                            $text = $crawler->filterXPath($contentFilterPath->getPath())->text();
                            break;
                        default:
                            $text = null;
                    }

                    $results[] = $text;

                    if ($syncResultValidator !== null && is_callable($syncResultValidator)) {
                        $result = $syncResultValidator($text);

                        if ($result) {
                            return $text;
                        }
                    }
                } catch (\RuntimeException $e) {
                    return null;
                }
            }
        } catch (GuzzleException $e) {
            return null;
        }

        if ($syncResultValidator !== null && is_callable($syncResultValidator)) {
            return null;
        }

        return $results;
    }
}
