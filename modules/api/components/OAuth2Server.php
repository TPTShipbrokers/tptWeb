<?php

namespace app\modules\api\components;

/**
 * Class OAuth2Server
 * @package app\modules\api\components
 */
class OAuth2Server extends \OAuth2\Server
{
    /**
     * @return AccessToken
     */
    protected function createDefaultAccessTokenResponseType()
    {
        if (!isset($this->storages['access_token'])) {
            throw new \LogicException("You must supply a response type implementing OAuth2\ResponseType\AccessTokenInterface, or a storage object implementing OAuth2\Storage\AccessTokenInterface to use the token server");
        }

        $refreshStorage = null;
        if (isset($this->storages['refresh_token'])) {
            $refreshStorage = $this->storages['refresh_token'];
        }

        $config = array_intersect_key($this->config,
            array_flip(explode(' ', 'access_lifetime refresh_token_lifetime')));
        $config['token_type'] = $this->tokenType ? $this->tokenType->getTokenType() : $this->getDefaultTokenType()->getTokenType();

        return new AccessToken($this->storages['access_token'], $refreshStorage, $config);
    }
}
