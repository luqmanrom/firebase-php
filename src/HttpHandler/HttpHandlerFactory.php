<?php

namespace Geckob\Firebase\HttpHandler;

use Geckob\Firebase\GoogleConsole;
use GuzzleHttp\ClientInterface;


class HttpHandlerFactory
{

    public static function setup($config, $path, GoogleConsole $googleConsole)
    {
        $version = ClientInterface::VERSION;

        switch ($version[0]) {
            case '5':
                return new Guzzle5HttpHandler($config, $googleConsole);
            case '6':
                return new Guzzle6HttpHandler($config, $googleConsole);
            default:
                throw new \Exception('Version not supported');
        }
    }



}