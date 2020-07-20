<?php

namespace App;

use App\ContentSite\ContentSiteInterface;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class ContentSiteRequestManager extends RequestManager
{
    /**
     * @param ContentSiteInterface $contentSite
     * @param string $searchStr
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function searchSite(ContentSiteInterface $contentSite, string $searchStr)
    {
        try {
            $request =  $this->doGetRequest($contentSite->getRequestUrl($searchStr));

            if ($request->getStatusCode() !== 200) {
                return null;
            }

            $body = $request->getBody()->getContents();
            $crawler = new Crawler($body);

            dump($crawler->filter($contentSite->getFilterPath())->text());
            //dump($body);
            exit;
        } catch (GuzzleException $e) {
            return null;
        }
    }
}
