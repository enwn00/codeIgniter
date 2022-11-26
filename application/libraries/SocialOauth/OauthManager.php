<?php

// Laravel Socialite 을 참고하여 제작
namespace App\Library\SocialOauth;

use App\Library\SocialOauth\Provider\KakaoProvider;
use App\Library\SocialOauth\Provider\NaverProvider;
use App\Library\SocialOauth\Provider\FacebookProvider;
use App\Library\SocialOauth\Provider\GoogleProvider;

class OauthManager
{
    private $config;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->config('social_sign', true);
        $this->config = $this->CI->config->item('config', 'social_sign');
    }

    /**
     * Create a new driver instance.
     *
     * @param string $driver
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function createDriver(string $driver)
    {
        $method = 'create'.$driver.'Driver';

        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    /**
     * Create an instance of the specified driver.
     *
     */
    public function createKakaoDriver()
    {
        $config = $this->config['kakao'];

        return $this->buildProvider(
            KakaoProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     */
    public function createNaverDriver()
    {
        $config = $this->config['naver'];

        return $this->buildProvider(
            NaverProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     */
    public function createFacebookDriver()
    {
        $config = $this->config['facebook'];

        return $this->buildProvider(
            FacebookProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     */
    public function createGoogleDriver()
    {
        $config = $this->config['google'];

        return $this->buildProvider(
            GoogleProvider::class, $config
        );
    }

    /**
     * Build an OAuth 2 provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->CI->input,
            $config['client_id'],
            $config['client_secret'],
            $config['redirect'],
            !empty($config['guzzle']) ? $config['guzzle'] : []
        );
    }
}
