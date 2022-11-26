<?php

namespace App\Library\SocialOauth\Provider;

use App\Library\SocialOauth\Contracts\Provider;

class KakaoProvider extends AbstractProvider implements Provider
{
    /**
     * The base Kakao Auth URL.
     *
     * @var string
     */
    protected $authUrl = 'https://kauth.kakao.com/oauth/authorize';

    /**
     * The base Kakao Token URL.
     *
     * @var string
     */
    protected $tokenUrl = 'https://kauth.kakao.com/oauth/token';

    /**
     * The base Kakao User Info URL.
     *
     * @var string
     */
    protected $userInfoUrl = 'https://kapi.kakao.com/v2/user/me';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl()
    {
        return $this->buildAuthUrl($this->authUrl);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return $this->tokenUrl;
    }

    protected function getUserByToken(string $token)
    {
        $response = $this->getHttpClient()->get($this->userInfoUrl, [
            'query' => ['access_token' => $token],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['properties']['nickname'],
            'email' => $user['kakao_account']['email'],
            'phoneNumber' => $user['kakao_account']['phone_number']
        ]);
    }
}
