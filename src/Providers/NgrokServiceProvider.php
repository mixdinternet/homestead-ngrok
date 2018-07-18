<?php

namespace Mixdinternet\Ngrok\Providers;

use Illuminate\Support\ServiceProvider;

class NgrokServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->providers();
    }

    public function register()
    {
        //
    }

    protected function providers()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
