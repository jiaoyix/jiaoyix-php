<?php

namespace Jiaoyix;

class Jiaoyix
{
    // @var string The Jiaoyix API key to be used for requests.
    public static $apiKey = '';

    // @var string The Jiaoyix API Secret to be used for requests.
    public static $apiSecret = '';

    // @var string The Jiaoyix App id to be used for requests.
    public static $appId = null;

    // @var string The base URL for the Jiaoyix API.
    public static $apiBase = 'https://api.jiaoyix.com';

    // @var string|null The version of the Jiaoyix API to use for requests.
    public static $apiVersion = 'V1';

    // @var boolean Defaults to true.
    public static $verifySslCerts = false;

    const VERSION = '2.0.0';

    /**
     * @return string The API key used for requests.
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string The API key used for requests.
     */
    public static function getApiSecret()
    {
        return self::$apiSecret;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiSecret($apiSecret)
    {
        self::$apiSecret = $apiSecret;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @return boolean
     */
    public static function getVerifySslCerts()
    {
        return self::$verifySslCerts;
    }

    /**
     * @param boolean $verify
     */
    public static function setVerifySslCerts($verify)
    {
        self::$verifySslCerts = $verify;
    }

    /**
     * @return string | null The Jiaoyix account ID for connected account
     *   requests.
     */
    public static function getAccountId()
    {
        return self::$accountId;
    }

    /**
     * @param string $accountId The Jiaoyix account ID to set for connected
     *   account requests.
     */
    public static function setAccountId($accountId)
    {
        self::$accountId = $accountId;
    }

    /**
     * @param string $ApiBase by chicheng 设置请求的路由
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @return string  by chicheng 获取请求的路由
     */
    public static function getApiBase()
    {
        return self::$apiBase;
    }

    /**
     * @param string $appId by chicheng 设置app_id
     */
    public static function setAppId($appId)
    {
        self::$appId = $appId;
    }

    /**
     * @return string  by chicheng 获取app_id
     */
    public static function getAppId()
    {
        return self::$appId;
    }
}
