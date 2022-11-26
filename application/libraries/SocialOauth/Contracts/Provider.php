<?php

namespace App\Library\SocialOauth\Contracts;

interface Provider
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return string
     */
    public function redirect();

    /**
     * Get the User instance for the authenticated user.
     *
     * @return \SocialOauth\Contracts\User
     */
    public function user();
}
