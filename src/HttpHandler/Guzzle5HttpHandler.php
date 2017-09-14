<?php

namespace Geckob\Firebase\HttpHandler;

use Geckob\Firebase\GoogleConsole;
use Google\Auth\Subscriber\AuthTokenSubscriber;
use GuzzleHttp\Client;
use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Event\Emitter;
use GuzzleHttp\Event\BeforeEvent;


class Guzzle5HttpHandler implements FirebaseInterface
{
    protected $config;

    protected $databaseUri;

    protected $http;

    protected $path;

    public function __construct($config, GoogleConsole $googleConsole)
    {
        $this->config = $config;

        $this->databaseUri = sprintf('https://%s.firebaseio.com/', $this->config['project_id']);

        $this->http = new Client([
            'base_url' => $this->databaseUri,
            'defaults' => [
                'auth' => 'google_auth'
            ]
        ]);

        $this->http->getEmitter()->attach(new AuthTokenSubscriber(
            new ServiceAccountCredentials(
                $googleConsole->getScopes(),
                $googleConsole->getCredentials()
            )));
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function set($key, $value)
    {
        $response = $this->http->put($this->path . $key . '.json', 
            ['body' => json_encode($value), 'timeout' => $this->config['timeout']]);

        return (string) $response->getBody();

    }

    public function get($key)
    {
        $response = $this->http->get($this->path. $key . '.json',  ['timeout' => $this->config['timeout']]);

        return (string) $response->getBody();


    }

    public function delete($key)
    {
        $response = $this->http->delete($this->path. $key . '.json',  ['timeout' => $this->config['timeout']]);

        return (string) $response->getBody();
    }

    public function push($arr)
    {
        $response = $this->http->post($this->path . '.json', 
            ['body' => json_encode($arr), 'timeout' => $this->config['timeout']]);

        return (string) $response->getBody();
    }

}