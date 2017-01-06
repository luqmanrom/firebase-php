<?php

namespace Geckob\Firebase\HttpHandler;

interface FirebaseInterface
{
    public function set($key, $value);

    public function get($key);

    public function delete($key);

    public function push($arr);
}