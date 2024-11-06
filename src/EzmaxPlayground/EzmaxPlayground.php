<?php

namespace App\EzmaxPlayground;

use Exception;
use eZmaxAPI\Api\GlobalCustomerApi;
use GuzzleHttp\Client;

class EzmaxPlayground
{
    private $apiInstance;

    public function __construct()
    {
        $this->apiInstance = new GlobalCustomerApi(new Client());
    }

    public function getCustomerEndpoint($pksCustomerCode, $sInfrastructureproductCode = 'appcluster01')
    {
        try {
            return $this->apiInstance->globalCustomerGetEndpointV1($pksCustomerCode, $sInfrastructureproductCode);
        } catch (Exception $e) {
            echo 'Exception when calling GlobalCustomerApi->globalCustomerGetEndpointV1: ', $e->getMessage(), PHP_EOL;
        }
    }
}
