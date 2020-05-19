<?php

declare(strict_types=1);

/*
 * Copyright (C) 2020 Rafal Masiarek <rafal@masiarek.pl>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace rafalmasiarek;

use GuzzleHttp\Client;

/**
 * This class is the base class.
 */
class hCaptcha
{
    /**
     * Guzzle http Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * URL for hCAPTCHA siteverify API
     * @const string
     */
    const SITE_VERIFY_URL = 'https://hcaptcha.com/siteverify';

    /**
     * Private key
     *
     * @var string
     */
    private $secretKey;
   
    /**
     * Remote IP address
     *
     * @var string
     */
    protected $remoteIp = null;

    /**
     * Guzzle http Client timeout (in seconds) to wait for response
     *
     * @var int
     */
    private $verifyTimeout = 0;

    /**
     * List of errors
     *
     * @var array
     */
    protected $errorCodes = array();

    /**
     * Initialize secret key
     *
     * @param string $secretKey Secret key from hCaptcha dashboard
     * @return void
     */
    public function __construct($secretKey = null)
    {
        $this->setSecretKey($secretKey);

        $this->httpClient = new Client([
            'timeout' => (bool) $this->verifyTimeout
        ]);
    }

    /**
     * Set secret key
     *
     * @param string $key
     * @return object
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * Set remote IP address
     *
     * @param string $ip
     * @return object
     */
    public function setRemoteIp($ip = null)
    {
        if (!is_null($ip))
            $this->remoteIp = $ip;
        else
            $this->remoteIp = $_SERVER['REMOTE_ADDR'];

        return $this;
    }

    /**
     * Set timeout
     *
     * @param  int $timeout
     * @return object
     */
    public function setVerifyTimeout($timeout)
    {
        $this->verifyTimeout = $timeout;

        return $this;
    }

    /**
     * Send verify request.
     *
     * @param array $query
     *
     * @return array
     */
    protected function sendRequest(array $query = [])
    {
        $response = $this->httpClient->post(static::SITE_VERIFY_URL, [
            'form_params' => $query,
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Checks the code given by the captcha
     *
     * @param string $responseToken Response code after submitting form  (usualy $_POST['h-captcha-response'])
     * @param string $remoteIp 
     * @return bool
     */
    public function verify($responseToken, $remoteIp = null)
    {
        if (is_null($this->secretKey)) {
            throw new \Exception('You must set your secret key');
        }

        if (empty($responseToken)) {

            $this->errorCodes = array('internal-empty-response');

            return false;
        }

        $this->setRemoteIp($remoteIp);

        return $this->sendRequest([
            'secret' => $this->secretKey,
            'remoteip' => $this->remoteIp,
            'response' => $responseToken,
        ]);

    }
}
