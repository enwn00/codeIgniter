<?php

namespace App\Library\SocialOauth\Provider;

use App\Library\SocialOauth\Contracts\Provider;

class FacebookProvider extends AbstractProvider implements Provider
{
    /**
     * The base Facebook Auth URL.
     *
     * @var string
     */
    protected $authUrl = 'https://www.facebook.com/v3.2/dialog/oauth';

    /**
     * The base Facebook Token URL.
     *
     * @var string
     */
    protected $tokenUrl = 'https://graph.facebook.com/v3.2/oauth/access_token';

    /**
     * The base Facebook User Info URL.
     *
     * @var string
     */
    protected $userInfoUrl = 'https://graph.facebook.com/me';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['public_profile','email'];

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
            'email' => '',
            'phoneNumber' => ''
        ]);
    }
}
