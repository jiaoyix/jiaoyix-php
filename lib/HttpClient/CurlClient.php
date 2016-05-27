<?php

namespace Jiaoyix\HttpClient;

use Jiaoyix\Jiaoyix;
use Jiaoyix\Error;
use Jiaoyix\Util;

class CurlClient implements ClientInterface
{
    private static $instance;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // USER DEFINED TIMEOUTS

    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;

    private $timeout = self::DEFAULT_TIMEOUT;
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;

    public function setTimeout($seconds)
    {
        $this->timeout = (int) max($seconds, 0);
        return $this;
    }

    public function setConnectTimeout($seconds)
    {
        $this->connectTimeout = (int) max($seconds, 0);
        return $this;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }

    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    // END OF USER DEFINED TIMEOUTS

    public function request($method, $absUrl, $headers, $params, $hasFile)
    {
        $curl = curl_init();
        $method = strtolower($method);
        $opts = array();
        if ($method == 'get') {
            if ($hasFile) {
                throw new Error\Api(
                    "Issuing a GET request with a file parameter"
                );
            }
            $opts[CURLOPT_HTTPGET] = 1;
            if (count($params) > 0) {
                $encoded = self::encode($params);
                $absUrl = "$absUrl?$encoded";
            }
        } elseif ($method == 'post') {
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $hasFile ? $params : self::encode($params);
        } elseif ($method == 'delete') {
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            if (count($params) > 0) {
                $encoded = self::encode($params);
                $absUrl = "$absUrl?$encoded";
            }
        } else {
            throw new Error\Api("Unrecognized method $method");
        }

        // Create a callback to capture HTTP headers for the response
        $rheaders = array();
        $headerCallback = function ($curl, $header_line) use (&$rheaders) {
            // Ignore the HTTP request line (HTTP/1.1 200 OK)
            if (strpos($header_line, ":") === false) {
                return strlen($header_line);
            }
            list($key, $value) = explode(":", trim($header_line), 2);
            $rheaders[trim($key)] = trim($value);
            return strlen($header_line);
        };

        $absUrl = Util\Util::utf8($absUrl);
        $opts[CURLOPT_URL] = $absUrl;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $opts[CURLOPT_TIMEOUT] = $this->timeout;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_HEADERFUNCTION] = $headerCallback;
        $opts[CURLOPT_HTTPHEADER] = $headers;

        if (!Jiaoyix::$verifySslCerts) {
            $opts[CURLOPT_SSL_VERIFYPEER] = false;
        }
        // @codingStandardsIgnoreStart
        // PSR2 requires all constants be upper case. Sadly, the CURL_SSLVERSION
        // constants to not abide by those rules.
        //
        // Opt into TLS 1.x support on older versions of curl. This causes some
        // curl versions, notably on RedHat, to upgrade the connection to TLS
        // 1.2, from the default TLS 1.0.
        if (!defined('CURL_SSLVERSION_TLSv1')) {
            define('CURL_SSLVERSION_TLSv1', 1); // constant not defined in PHP < 5.5
        }
        $opts[CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1;
        // @codingStandardsIgnoreEnd

        // TODO debug
        file_put_contents('/tmp/jiaoyix-request.log', var_export(array(
             $method,
             $opts[CURLOPT_URL],
             $opts[CURLOPT_HTTPHEADER],
             $params,
             $opts[CURLOPT_POSTFIELDS]), true), FILE_APPEND);

        curl_setopt_array($curl, $opts);
        $rbody = curl_exec($curl);

        if (!defined('CURLE_SSL_CACERT_BADFILE')) {
            define('CURLE_SSL_CACERT_BADFILE', 77);  // constant not defined in PHP
        }

        $errno = curl_errno($curl);
        if ($errno == CURLE_SSL_CACERT ||
            $errno == CURLE_SSL_PEER_CERTIFICATE ||
            $errno == CURLE_SSL_CACERT_BADFILE
        ) {
            array_push(
                $headers,
                'X-Jiaoyix-Client-Info: {"ca":"using Jiaoyix-supplied CA bundle"}'
            );
            $cert = self::caBundle();
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_CAINFO, $cert);
            $rbody = curl_exec($curl);
        }

        if ($rbody === false) {
            $errno = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            $this->handleCurlError($absUrl, $errno, $message);
        }

        $rcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // TODO debug
        file_put_contents('/tmp/jiaoyix-response.log', var_export(array(
             $rbody,
             $rcode,
             $rheaders), true), FILE_APPEND);

        return array($rbody, $rcode, $rheaders);
    }

    /**
     * @param number $errno
     * @param string $message
     * @throws Error\ApiConnection
     */
    private function handleCurlError($url, $errno, $message)
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = "Could not connect to Jiaoyix ($url).  Please check your "
                 . "internet connection and try again.  If this problem persists, "
                 . "you should check Jiaoyix's service status at "
                 . "https://twitter.com/jiaoyixstatus, or";
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = "Could not verify Jiaoyix's SSL certificate.  Please make sure "
                 . "that your network is not intercepting certificates.  "
                 . "(Try going to $url in your browser.)  "
                 . "If this problem persists,";
                break;
            default:
                $msg = "Unexpected error communicating with Jiaoyix.  "
                 . "If this problem persists,";
        }
        $msg .= " let us know at support@jiaoyix.com.";

        $msg .= "\n\n(Network error [errno $errno]: $message)";
        throw new Error\ApiConnection($msg);
    }

    private static function caBundle()
    {
        return dirname(__FILE__) . '/../../data/ca-certificates.crt';
    }

    /**
     * @param array $arr An map of param keys to values.
     * @param string|null $prefix
     *
     * Only public for testability, should not be called outside of CurlClient
     *
     * @return string A querystring, essentially.
     */
    public static function encode($arr, $prefix = null)
    {
        return http_build_query($arr, $prefix);
    }
}
