<?php
namespace rafalmasiarek\hCaptcha\Request;

interface RequestMethodInterface
{
    public function submit(string $url, array $params): array|false;
}
