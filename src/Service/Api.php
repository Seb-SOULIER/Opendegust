<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class Api
{
    public const STATUS_CODE = 200;

    public function getResponse(string $url): array
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);
        $statusCode = $response->getStatusCode();
        if ($statusCode === self::STATUS_CODE) {
            // get the response in JSON format
            return $response->toArray();
            // convert the response (here in JSON) to an PHP array
        }
        return ['status' => $response->getStatusCode()];
    }
}
