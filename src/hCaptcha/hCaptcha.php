<?php

/*
 * Copyright (C) 2020-2025 Rafal Masiarek <rafal@masiarek.pl>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace rafalmasiarek\hCaptcha;

use rafalmasiarek\hCaptcha\Request\RequestMethodInterface;
use rafalmasiarek\hCaptcha\Request\CurlRequestMethod;

final class hCaptcha
{
    private const SITE_VERIFY_URL = 'https://hcaptcha.com/siteverify';

    private string $secretKey;
    private ?string $remoteIp = null;
    private int $verifyTimeout = 5;
    private array $errorCodes = [];
    private RequestMethodInterface $requestMethod;

    public function __construct(string $secretKey, ?RequestMethodInterface $method = null)
    {
        $this->secretKey = $secretKey;
        $this->requestMethod = $method ?? new CurlRequestMethod($this->verifyTimeout);
    }

    public function setRemoteIp(?string $ip): self
    {
        $this->remoteIp = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? null);
        return $this;
    }

    public function setVerifyTimeout(int $timeout): self
    {
        $this->verifyTimeout = $timeout;
        return $this;
    }

    public function verify(string $responseToken, ?string $remoteIp = null): bool
    {
        $this->errorCodes = [];

        if (empty($responseToken)) {
            $this->errorCodes[] = 'empty-response';
            return false;
        }

        $this->setRemoteIp($remoteIp);

        $result = $this->requestMethod->submit(self::SITE_VERIFY_URL, [
            'secret' => $this->secretKey,
            'response' => $responseToken,
            'remoteip' => $this->remoteIp,
        ]);

        if ($result === false || empty($result['success'])) {
            $this->errorCodes = $result['error-codes'] ?? ['invalid-response'];
            return false;
        }

        return true;
    }

    public function getLastErrorCodes(): array
    {
        return $this->errorCodes;
    }
}
