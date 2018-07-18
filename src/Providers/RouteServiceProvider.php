<?php

namespace Mixdinternet\Ngrok\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //https://laracasts.com/discuss/channels/servers/homestead-ngrok/replies/399019

        $scheme = '';
        $host = '';
        $url = parse_url(config('app.url'));
        $baseHost = $url['host'];
        $baseScheme = $url['scheme'];

        if (isset($_SERVER['HTTP_X_ORIGINAL_HOST'])) {
            $scheme = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : $baseScheme;
            $host = isset($_SERVER['HTTP_X_ORIGINAL_HOST']) ? $_SERVER['HTTP_X_ORIGINAL_HOST'] : '';
        }

        if (isset($_SERVER['HTTP_REFERER'])) {
            $info = parse_url($_SERVER['HTTP_REFERER']);
            $host = $info['host'];
            $scheme = $info['scheme'];
        }

        if ($host != '' && $host != $baseHost && preg_match("#ngrok\.io#", $host)) {
            $scheme ?: $baseScheme;
            URL::forceRootUrl("{$scheme}://{$host}");
        }

        parent::boot();
    }
}
