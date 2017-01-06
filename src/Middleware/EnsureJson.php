<?php

namespace Geckob\Firebase\Middleware;

use Psr\Http\Message\RequestInterface;


class EnsureJson
{
    public static function run()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options = []) use ($handler) {
                $uri = $request->getUri();
                $path = $uri->getPath();

                if (substr($path, -5) !== '.json') {
                    $uri = $uri->withPath($path.'.json');
                    $request = $request->withUri($uri);
                }

                $request = $request->withHeader('Content-Type', 'application/json');

                return $handler($request, $options);
            };
        };
    }



}