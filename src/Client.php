<?php
namespace Profits4Purpose\GuideStar;

use GuzzleHttp\Client as Guzzle;

class Client
{
    protected $baseUrl = 'https://data.guidestar.org/v1';

    private $username;
    private $password;

    /**
     * @var Guzzle
     */
    private $httpClient;

    /**
     * Instantiate GuideStar API client
     *
     * @param $username string Username or API Key
     * @param null $password string Password (leave blank if you have an API key)
     */
    public function __construct($username, $password = null)
    {
        $this->username = $username;
        if ($password) {
            $this->password = $password;
        }
    }

    protected function getJson($url)
    {
        $client = $this->getHttpClient();
        $response = $client->get($url, ['auth' => [$this->username, $this->password]]);
        return $response->json(['object' => true]);
    }

    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new Guzzle();
        }
        return $this->httpClient;
    }

    protected function normalizeEin($ein)
    {
        $ein = preg_replace("/[^\d]/", '', $ein);
        return substr($ein, 0, 2) . '-' . substr($ein, 2);
    }
}
