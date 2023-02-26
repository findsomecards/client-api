<?php

namespace Findsome\Client\Classes;

use Findsome\Client\Enums\RequestType;

class Client extends Builder
{
    protected function makeRequest(string $endpoint, array $params = [], string $method = RequestType::GET)
    {
        $url = $this->buildUrl($endpoint);

        if( !strcmp($method, RequestType::GET) && !empty($params)) {
            $url = $this->buildUrlWithParams($url, $params);
        }

        $ch = curl_init();
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2';
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->commonHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        if( !strcmp($method, RequestType::POST) && !empty($params)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        $errors = curl_error($ch);
        curl_close($ch);
        

        return json_decode($response);
    }

}
