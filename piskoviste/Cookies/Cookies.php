<?php

/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Cookies
{
    /**
     * @param Response $response
     * @param string $key
     * @param string $value
     * @return Response
     */
    public function deleteCookie(Response $response, $key)
    {
        $cookie = urlencode($key).'='.
            urlencode('deleted').'; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=0; path=/; secure; httponly';
        $response = $response->withAddedHeader('Set-Cookie', $cookie);
        return $response;
    }

    /**
     * @param Response $response
     * @param string $cookieName
     * @param string $cookieValue
     * @return Response
     */
    public function addCookie(Response $response, $cookieName, $cookieValue)
    {
        $expirationMinutes = 10;
        $expiry = new \DateTimeImmutable('now + '.$expirationMinutes.'minutes');
        $cookie = urlencode($cookieName).'='.
            urlencode($cookieValue).'; expires='.$expiry->format(\DateTime::COOKIE).'; Max-Age=' .
            $expirationMinutes * 60 . '; path=/; secure; httponly';
        $response = $response->withAddedHeader('Set-Cookie', $cookie);
        return $response;
    }

    /**
     * @param Request $request
     * @param string $cookieName
     * @return string
     */
    public function getCookieValue(Request $request, $cookieName)
    {
        $cookies = $request->getCookieParams();
        return isset($cookies[$cookieName]) ? $cookies[$cookieName] : null;
    }

}
