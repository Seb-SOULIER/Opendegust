<?php

namespace App\Controller;

use App\Service\Api;

class ApiController
{
    public function map(string $address): array
    {
        /**
         * @example with map
         */
        $api = new Api();
        $url = "https://nominatim.openstreetmap.org/search?q=$"
            . $address . "&format=json&addressdetails=1&limit=1&polygon_svg=1";
        $response = $api->getResponse($url);
        return $response;
    }

    public function zipCode(string $zip): array
    {
        $api = new Api();
        $url = "https://geo.api.gouv.fr/communes?codePostal=" . $zip;
        $response = $api->getResponse($url);
        return $response;
    }
    public function frenchApi(string $city): array
    {
        $api = new Api();
        $url = "https://geo.api.gouv.fr/communes?codePostal=" . $city;
        $response = $api->getResponse($url);
        return $response;
    }
}
