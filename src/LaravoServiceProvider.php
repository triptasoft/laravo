<?php

namespace Triptasoft\Laravo;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Triptasoft\Laravo\Facades\Laravo as LaravoFacade;
use TCG\Voyager\Facades\Voyager;

class LaravoServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Triptasoft\Laravo\Commands\InstallCommand',
        'Triptasoft\Laravo\Commands\MakeModelCommand',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Laravo', LaravoFacade::class);
        $this->app->singleton('laravo', function () {
            return new Laravo();
        });

        $this->commands($this->commands);

        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/vendor'),
        ], 'laravo');

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'laravo');

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravo.php',
            'laravo'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'laravo');
        // Voyager::useModel('User', \App\User::class);
    }
}
