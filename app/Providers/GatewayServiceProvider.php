<?php

namespace App\Providers;

use App\Cores\Request;
use App\Services\Gateway\Base\BaseServiceContract;
use App\Services\Gateway\Rest\RestService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->app->singleton(BaseServiceContract::class, function () {
            return new RestService(
                new Client([
                    'timeout' => Config::get('gateway.timeout'),
                    'connect_timeout' =>
                        Config::get('gateway.connect_timeout',
                            Config::get('gateway.timeout')
                        )
                ])
            );
        });

    }

    public function register()
    {
        //
    }

    protected function prepareRequest(Request $request)
    {
        return $request;
    }
}
