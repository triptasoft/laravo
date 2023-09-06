<?php

namespace Triptasoft\Laravo;

use Illuminate\Support\ServiceProvider;

class LaravoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands(Commands\InstallCommand::class);
    }
}
