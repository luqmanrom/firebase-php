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

    public function __construct($secretFilePath = null, $config = ['timeout' => 0])
    {
        if (func_num_args() == 0) {
            $secretFilePath = config('laravel-firebase.secretPath');
        }

        $this->config = array_merge($this->extractSecrets($secretFilePath), $config);

        $googleConsole = new GoogleConsole($this->config);

        $this->httpClient = HttpHandlerFactory::setup($this->config, $this->path, $googleConsole);

    }

    private function extractSecrets($secretFilePath)
    {
        $config = file_get_contents($secretFilePath);
        return json_decode($config, true);
    }

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