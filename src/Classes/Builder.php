<?php

namespace Findsome\Client\Classes;

use Findsome\Client\Enums\RequestType;

class Builder
{
    protected $config;

    public function __construct()
    {
        $this->config = make_object(get_config('findsome'));
    }

    public function buildUrl($endpoint)
    {
        return "{$this->config->base_uri}/{$endpoint}";
    }

    public function buildUrlWithParams($url, $params)
    {
        $params = build_get_param($params);

        return $url.$params;
    }

    public function commonHeaders()
    {
        return [
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer {$this->config->api_token}"
        ];
    }
}
