<?php

namespace NodeRED;

class OAuth
{
    private $instance;

    const CLIENT_NODE_RED_ADMIN = 'node-red-admin';
    const CLIENT_NODE_RED_EDITOR = 'node-red-editor';

    const SCOPE_ALL = '*';
    const SCOPE_READ = 'read';

    public function __construct(Instance $instance)
    {
        $this->instance = $instance;
    }

    public function getToken($username, $password, $clientId = self::CLIENT_NODE_RED_ADMIN, $scope = self::SCOPE_ALL)
    {
        $data = $this->instance->formPost('auth/token', [
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
            'client_id' => $clientId,
            'scope' => $scope
        ]);

        return new OAuthToken($data['access_token'], $data['expires_in'], $data['token_type']);
    }
}
