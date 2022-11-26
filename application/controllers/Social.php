<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use SocialOauth\OauthManager;

class Social extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Redirect the user to the Social authentication page.
     */
    public function signIn($type) {
        $manager = new OauthManager();
        redirect($manager->createDriver($type)->redirect());
    }

    /**
     * Obtain the user information from Social.
     */
    public function handleProviderCallBack($type){
        $manager = new OauthManager();
        $user = $manager->createDriver($type)->user();

        echo '<pre>';
        print_r($user);
        echo '</pre>';
        exit;
    }
}
