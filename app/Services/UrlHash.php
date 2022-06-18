<?php

namespace App\Services;

class UrlHash
{
    /**
     * Create a short, fairly unique, urlsafe hash for the Input URL.
     */

    public function createUrlHash($url, $length = 6)
    {
        $hash_base64 = base64_encode(hash('sha256', $url, true));
        $hash = strtr($hash_base64, '+/', '-_');
        $hash = rtrim($hash, '=');

        return substr($hash, 0, $length);
    }
}
