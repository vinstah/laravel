<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class CalculatorAPI
{

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl = 'http://prowood-api-v1.staging.cardo.nz/api/v1';

    /**
     * @var bool
     */
    private $returnResponses;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * HermesCore constructor.
     *
     * @param string $token
     * @param string|null $baseUrl
     */
    public function __construct($baseUrl = null)
    {
        $this->client = new Client([
            'base_uri' => $baseUrl ?: env('API_URL', $this->baseUrl),
            'http_errors' => false
        ]);
    }

    /**
     * @param      $membershipId
     * @param bool $includeMember
     *
     * @return mixed
     */
    public function getCalculation($segment, $params)
    {
        return $this->call('GET', $segment, $params);
    }

    /**
     * @param string $method
     * @param null $uri
     * @param array $params
     * @param bool $returnResponseObj
     *
     * @return mixed
     *
     * @throws Exception
     */
    protected function call($method, $uri = null, array $params = [], $returnResponseObj = false)
    {
        
        $options = $this->getOptions($method, $params);
        $query = '?';
        
        $filtered = array_filter($params, function($key) {
            return !\is_array($key);
        } );
   
        $lastKey = (array_keys($filtered)[count($filtered)-1]);

        array_walk($filtered, function($val, $key) use (&$query, $lastKey){
            $query .= $key.'=' . $val;
            if ($key !== $lastKey) {
                $query .= '&';
            }
        });
    

        $response = $this->client->get(env('API_URL', $this->baseUrl) . $uri . $query);
        $this->setStatusCode($response->getStatusCode());
        
        if ($returnResponseObj || $this->returnResponses) {
            return $response;
        }

        $responseData = json_decode($response->getBody());
       
        //@todo handle errors
        switch ($response->getStatusCode()) {
            case 200:
            case 201:
            case 204:
                return $responseData;

            /*case 422:
                throw new ValidationException((array)$responseData->errors);*/

            default:
                var_dump($responseData);
            // throw $responseData;
            // throw new \Exception($responseData);
        }
    }

    /**
     * @param string $method
     * @param array $params
     *
     * @return array
     */
    private function getOptions($method, array $params = [])
    {
        $options = [];

        // $options['headers']['Accept'] = 'application/json';

        if (!empty($params)) {
            switch ($method) {
                case 'get':
                    $options['query'] = $params;
                    break;

                default:
                    $options['json'] = $params;
                    break;
            }
        }

        return $options;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }
}
