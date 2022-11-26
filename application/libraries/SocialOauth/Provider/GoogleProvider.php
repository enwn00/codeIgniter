<?php

namespace App\Library\SocialOauth\Provider;

use App\Library\SocialOauth\Contracts\Provider;

class GoogleProvider extends AbstractProvider implements Provider
{
    /**
     * The base Google Auth URL.
     *
     * @var string
     */
    protected $authUrl = 'https://accounts.google.com/o/oauth2/auth';

    /**
     * The base Google Token URL.
     *
     * @var string
     */
    protected $tokenUrl = 'https://oauth2.googleapis.com/token';

    /**
     * The base Google User Info URL.
     *
     * @var string
     */
    protected $userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['profile email'];

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
            'name' => $user['name'],
            'email' => $user['email'],
            'phoneNumber' => ''
        ]);
    }
}
