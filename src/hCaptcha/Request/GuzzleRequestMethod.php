<?php

/*
 * Copyright (C) 2020-2025 Rafal Masiarek <rafal@masiarek.pl>
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace rafalmasiarek\hCaptcha\Request;

use GuzzleHttp\Client;

class GuzzleRequestMethod implements RequestMethodInterface
{
    private Client $client;

    public function __construct(int $timeout = 5)
    {
        $this->client = new Client(['timeout' => $timeout]);
    }

    public function submit(string $url, array $params): array|false
    {
        try {
            $res = $this->client->post($url, [
                'form_params' => $params,
            ]);
            return json_decode((string) $res->getBody(), true);
        } catch (\Throwable) {
            return false;
        }
    }
}
