<?php

/*
 * Copyright (C) 2020-2025 Rafal Masiarek <rafal@masiarek.pl>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */
namespace rafalmasiarek\hCaptcha\Request;

class CurlRequestMethod implements RequestMethodInterface
{
    private int $timeout;

    public function __construct(int $timeout = 5)
    {
        $this->timeout = $timeout;
    }

    public function submit(string $url, array $params): array|false
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);
        return json_decode($response, true);
    }
}
