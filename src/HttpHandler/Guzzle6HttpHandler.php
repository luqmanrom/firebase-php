<?php

namespace Geckob\Firebase\HttpHandler;

use Geckob\Firebase\GoogleConsole;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\Middleware\AuthTokenMiddleware;
use Geckob\Firebase\Middleware\EnsureJson;
use GuzzleHttp\Psr7\Uri;

class Guzzle6HttpHandler implements FirebaseInterface
{

    protected $config;

    protected $databaseUri;

    protected $http;

    protected $path;

    public function __construct($config, GoogleConsole $googleConsole)
    {

        $this->config = $config;

        $this->databaseUri = new Uri(sprintf('https://%s.firebaseio.com', $this->config['project_id']));

        $googleAuthTokenMiddleware = new AuthTokenMiddleware(
            new ServiceAccountCredentials(
                $googleConsole->getScopes(),
                $googleConsole->getCredentials()
            ));

        $stack = HandlerStack::create();
        $stack->push(EnsureJson::run(), 'ensure_json');
        $stack->push($googleAuthTokenMiddleware, 'auth_service_account');

        $this->http = new Client([
            'base_uri' => $this->databaseUri,
            'handler' => $stack,
            'auth' => 'google_auth',
        ]);

    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function set($key, $value)
    {

        $response = $this->http->request('PUT', $this->databaseUri->withPath($this->path.$key),
            ['body' => json_encode($value), 'timeout' => $this->config['timeout']]
        );

        return $response->getBody()->getContents();


    }

    public function get($key)
    {

        $response = $this->http->request('GET', $this->databaseUri->withPath($this->path. $key,
            ['timeout' => $this->config['timeout']]));

        return $response->getBody()->getContents();

    }

    public function delete($key)
    {
        $response = $this->http->request('DELETE', $this->databaseUri->withPath($this->path. $key,
            ['timeout' => $this->config['timeout']]));

        return $response->getBody()->getContents();
    }

    public function push($arr)
    {
        $response = $this->http->request('POST', $this->databaseUri->withPath($this->path),
            ['body' => json_encode($arr), 'timeout' => $this->config['timeout']]);

        return $response->getBody()->getContents();
    }

}