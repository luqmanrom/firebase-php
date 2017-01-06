<?php

namespace Geckob\Firebase;

use Geckob\Firebase\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client;

class Firebase
{
    protected $config;

    protected $httpClient;

    protected $path;

    public function __construct($secretFilePath)
    {
        $this->config = $this->extractSecrets($secretFilePath);

        $googleConsole = new GoogleConsole($this->config);

        $this->httpClient = HttpHandlerFactory::setup($this->config, $this->path, $googleConsole);

    }

    private function extractSecrets($secretFilePath)
    {
        $config = file_get_contents($secretFilePath);
        return json_decode($config, true);
    }


//    public function getIDToken()
//    {
//        $scopes = [
//            'https://www.googleapis.com/auth/userinfo.email',
//            'https://www.googleapis.com/auth/firebase.database',
//        ];
//
//        $credentials = [
//            'client_email' => $this->config['client_email'],
//            'client_id' => $this->config['client_id'],
//            'private_key' => $this->config['private_key'],
//        ];
//
//        $response =new ServiceAccountCredentials($scopes, $credentials);
//
//        $token = $response->fetchAuthToken();
//
//        return $token;
//
//    }

    public function setPath($path)
    {
        $this->path = $path;

        $this->httpClient->setPath($path);

        return $this;
    }


    public function set($key, $value)
    {
        $this->httpClient->set($key, $value);
    }

    public function get($key)
    {
        return $this->httpClient->get($key);
    }

    public function delete($key)
    {
        $this->httpClient->delete($key);
    }

    public function push($arr)
    {
        $this->httpClient->push($arr);
    }


}