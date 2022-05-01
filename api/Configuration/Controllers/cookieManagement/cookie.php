<?php

include_once __DIR__ . "../../db.php";
include_once __DIR__ . "../../queries.php";

interface IAuthenticationCookie {
    public function authCookieSetter(
        $tokenRequest,
        $tokenTimeStamp,
        $tokenPath,
        $isSecure,
        $isHttp,
        $isSameSite,
        $tokenName
    );
}

class TokenParams
{
    public static $tokenInitialize = null;
}

class AuthCookieManagement implements IAuthenticationCookie {
    public function authCookieSetter($tokenRequest, $tokenTimeStamp, $tokenPath, $isSecure, $isHttp, $isSameSite, $tokenName)
    {
        TokenParams::$tokenInitialize = array (
            'expires' => $tokenTimeStamp,
            'path' => $tokenPath,
            'secure' => $isSecure,
            'httponly' => $isHttp,
            'samesite' => $isSameSite
        );
        setcookie($tokenName, $tokenRequest, TokenParams::$tokenInitialize);
    }
}