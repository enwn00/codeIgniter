<?php

namespace App\Library\SocialOauth\Provider;

use App\Library\SocialOauth\Contracts\Provider;

class NaverProvider extends AbstractProvider implements Provider
{
    /**
     * The base Naver Auth URL.
     *
     * @var string
     */
    protected $authUrl = 'https://nid.naver.com/oauth2.0/authorize';

    /**
     * The base Naver Token URL.
     *
     * @var string
     */
    protected $tokenUrl = 'https://nid.naver.com/oauth2.0/token';

    /**
     * The base Naver User Info URL.
     *
     * @var string
     */
    protected $userInfoUrl = 'https://openapi.naver.com/v1/nid/me';

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
            'query' => [
                'prettyPrint' => 'false',
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['response']['id'],
            'name' => $user['response']['name'],
            'email' => $user['response']['email'],
            'phoneNumber' => $user['response']['mobile']
        ]);
    }

}
