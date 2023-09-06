<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'laravo:install';
    protected $description = 'Install Passport keys';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Artisan::command('laravo:install', function () {
            Artisan::call('voyager:install --with-dummy');
            Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);
            Artisan::call('passport:install');
            Artisan::call('joy-voyager-api:l5-swagger:generate');
            Artisan::call('storage:link');
            Artisan::call('cache:clear');
        // })->describe('Installing Laravo');

        $output = Artisan::output();

        $this->info('Passport keys have been installed.');
    }
}