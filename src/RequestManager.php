<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class RequestManager
{
    /**
     * The headers for the request
     * @return array headers
     */
    protected function getHeaders()
    {
        return [
            'Accept'         => 'application/html',
            'Content-Type'   => 'application/html',
            'Cache-Control'  => 'no-cache',
        ];
    }

    /**
     * Make a request for content
     * @param string $url url to request
     * @return ResponseInterface Request object
     * @throws GuzzleException
     */
    protected function doGetRequest($url)
    {
        $client = new Client([
            'timeout' => 20,
            'connect_timeout' => 10,
            'verify' => false // Compatibility for windows - Windows was throwing weird CA Cert errors and due to not being important about verifying source lets do this instead...
        ]);

        return $client->request(
            'GET',
            $url,
            [
                'headers' => $this->getHeaders(),
                'http_errors' => false,
            ]
        );
    }
}
