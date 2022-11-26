<?php
defined('BASEPATH') OR exit('No direct script access allowed');

const REDIRECT_URL = BASE_URL."/ko/social/handleProviderCallBack";

$config['config']['kakao'] = [
    'client_id' => "your client_id",
    'client_secret' => "your client_secret",
    'redirect' => REDIRECT_URL."/Kakao",
];

$config['config']['naver'] = [
    'client_id' => "your client_id",
    'client_secret' => "your client_secret",
    'redirect' => REDIRECT_URL."/Naver",
];

$config['config']['facebook'] = [
    'client_id' => "your client_id",
    'client_secret' => "your client_secret",
    'redirect' => REDIRECT_URL."/Facebook",
];

$config['config']['google'] = [
    'client_id' => "your client_id",
    'client_secret' => "your client_secret",
    'redirect' => REDIRECT_URL."/Google",
];
