<?php

namespace Triptasoft\Laravo;

use Illuminate\Support\ServiceProvider;

class LaravoServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Triptasoft\Laravo\Commands\InstallCommand',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        include __DIR__.'/routes/web.php';
        $this->commands($this->commands);
        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/vendor/voyager'),
        ], 'laravo');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
