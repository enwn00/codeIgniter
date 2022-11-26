<?php

namespace App\Library\SocialOauth\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \SocialOauth\Contracts\Provider
     */
    public function driver($driver = null);
}
