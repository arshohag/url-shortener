<?php

namespace App\Services;

class UrlHash
{

    /**
     * Get all existing hash
     */
    private $existingHash;

    public function __construct()
    {
        $this->existingHash = Url::all('hash')->pluck('hash')->toArray();
    }

    /**
     * Create a short, unique, urlsafe hash for the Input URL.
     */

    public function createUrlHash($url, $length = 6)
    {
        $hash = $this->_makeHash($url, $length);
        return $this->_generateUniqueHash($hash, $url, $length);
    }

    /**
     * Check for unique hash
     */
    private function _isUniqueHash($newHash)
    {
        return !in_array($newHash, $this->existingHash);
    }

    /**
     * Make the hash string
     */
    private function _makeHash($url, $length)
    {
        $hash_base64 = base64_encode(hash('sha256', $url, true));
        $hash = strtr($hash_base64, '+/', '-_');
        $hash = rtrim($hash, '=');

        return substr($hash, 0, $length);
    }

    /**
     * Generate unique hash
     */
    private function _generateUniqueHash($hash, $url, $length)
    {
        if($this->_isUniqueHash($hash)){
            return $hash;
        }

        $url .= time() . rand(0,9999999);
        return $this->_makeHash($url, $length);
    }
}
