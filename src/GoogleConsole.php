<?php

namespace Geckob\Firebase;


class GoogleConsole
{
    protected $scopes;

    protected $credentials;

    public function __construct($config)
    {
        $this->scopes = [
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/firebase.database',
        ];

        $this->credentials = [
            'client_email' => $config['client_email'],
            'client_id' => $config['client_id'],
            'private_key' => $config['private_key'],
        ];
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function getScopes()
    {
        return $this->scopes;
    }

}