<?php

namespace SisFin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\SisFin\Repositories\MyModelRepository::class, \SisFin\Repositories\MyModelRepositoryEloquent::class);
        $this->app->bind(\SisFin\Repositories\BancoRepository::class, \SisFin\Repositories\BancoRepositoryEloquent::class);
        $this->app->bind(\SisFin\Repositories\ContaBancariaRepository::class, \SisFin\Repositories\ContaBancariaRepositoryEloquent::class);
        $this->app->bind(\SisFin\Repositories\ClienteRepository::class, \SisFin\Repositories\ClienteRepositoryEloquent::class);
        $this->app->bind(\SisFin\Repositories\CategoriaRepository::class, \SisFin\Repositories\CategoriaRepositoryEloquent::class);
        //:end-bindings:
    }
}
