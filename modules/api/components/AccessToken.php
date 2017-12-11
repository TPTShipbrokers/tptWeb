<?php

namespace app\modules\api\components;

/**
 * Class AccessToken
 * @package app\modules\api\components
 */
class AccessToken extends \OAuth2\ResponseType\AccessToken
{
    /**
     * @param int $client_id
     * @param int $user_id
     * @param null $scope
     * @param bool $includeRefreshToken
     * @return array
     */
    public function createAccessToken($client_id, $user_id, $scope = null, $includeRefreshToken = true)
    {
        $token = [
            "access_token" => $this->generateAccessToken(),
            "expires_in" => $this->config['access_lifetime'],
            "token_type" => $this->config['token_type'],
            //"scope" => $scope,
            "issued" => date('Y-m-d H:i:s', time())
        ];

        $this->tokenStorage->setAccessToken($token["access_token"], $client_id, $user_id,
            $this->config['access_lifetime'] ? time() + $this->config['access_lifetime'] : null, $scope);

        /*
         * Issue a refresh token also, if we support them
         *
         * Refresh Tokens are considered supported if an instance of OAuth2\Storage\RefreshTokenInterface
         * is supplied in the constructor
         */
        if ($includeRefreshToken && $this->refreshStorage) {
            $token["refresh_token"] = $this->generateRefreshToken();
            $expires = 0;
            if ($this->config['refresh_token_lifetime'] > 0) {
                $expires = time() + $this->config['refresh_token_lifetime'];
            }
            $this->refreshStorage->setRefreshToken($token['refresh_token'], $client_id, $user_id, $expires, $scope);
        }

        return $token;
    }
}
