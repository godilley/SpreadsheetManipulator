<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RequestManager
{

    /**
     * The headers for the request
     * @return array headers
     */
    private function getHeaders()
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
     * @return mixed Request object
     * @throws GuzzleException
     */
    private function doGetRequest($url)
    {
        $client = new Client([
            'timeout' => 20,
            'connect_timeout' => 10
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
