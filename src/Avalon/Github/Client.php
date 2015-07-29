<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 7/28/15
 * Time: 10:18 AM
 */

namespace Avalon\Github;

use GuzzleHttp\Client as Http;

class Client
{
    /**
     * @var Http
     */
    private $http;

    /**
     * @param Http $client
     */
    public function __construct(Http $client)
    {
        $this->http = $client;
    }

    /**
     * @param $token
     * @return mixed
     * @throws \Exception
     */
    public function getOrganization($token)
    {
        $response = $this->http->get('/user/orgs', ['Authorization' => "token $token"]);

        $body = $response->getBody()->getContents();
        $json = json_decode($body, true);
        if(json_last_error()) {
            throw new \Exception(json_last_error_msg());
        }

        return $json;
    }
}