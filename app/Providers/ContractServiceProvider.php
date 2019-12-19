<?php

namespace App\Providers;

use App\Services\GitInfoService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\GitInfoServiceContract;

class ContractServiceProvider extends ServiceProvider
{
    protected $contracts = [
        GitInfoServiceContract::class => GitInfoService::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->contracts as $abstract => $className) {
            $this->app->bind($abstract, $className);
        }
    }
}