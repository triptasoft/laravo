<?php

namespace Triptasoft\Laravo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'laravo:install';
    protected $description = 'Install Laravo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Filesystem $filesystem)
    {
        $this->info('Migrating database');
        Artisan::call('voyager:install --with-dummy');
        $this->info('Seeding database');
        Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);
        $this->info('Installing passport');
        Artisan::call('passport:install');
        $this->info('Publishing assets');
        Artisan::call('vendor:publish', ['--provider' => 'Joy\VoyagerApi\VoyagerApiServiceProvider']);
        Artisan::call('vendor:publish', ['--provider' => 'MonstreX\VoyagerExtension\VoyagerExtensionServiceProvider', '--tag' => 'config']);
        Artisan::call('optimize');
        Artisan::call('joy-voyager-api:l5-swagger:generate');
        Artisan::call('vendor:publish --tag=laravo');
        Artisan::call('db:seed', ['--class' => 'LaravoSettingsTableSeeder']);
        Artisan::call('cache:clear');

        $output = Artisan::output();

        $this->info('Adding Laravo routes to routes/web.php');
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'Laravo::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                PHP_EOL.PHP_EOL."Route::group(['prefix' => '/'], function () {".PHP_EOL."    Laravo::routes();".PHP_EOL."});".PHP_EOL
            );
        }

        $this->info('Adding service to config/services.php');
        $servicesFilePath = config_path('services.php');
        $servicesContents = $filesystem->get($servicesFilePath);
        
        if (!str_contains($servicesContents, "'google' =>")) {
            $newConfig = "\n    'google' => [\n";
            $newConfig .= "        'client_id' => env('GOOGLE_CLIENT_ID'),\n";
            $newConfig .= "        'client_secret' => env('GOOGLE_CLIENT_SECRET'),\n";
            $newConfig .= "        'redirect' => env('GOOGLE_CLIENT_REDIRECT'),\n";
            $newConfig .= "    ],\n";
        
            $servicesContents = preg_replace('/];/', $newConfig . '];', $servicesContents);
            
            $filesystem->put($servicesFilePath, $servicesContents);
        }
        $this->info('Service added successfully!');

        $this->info('Adding guard to config/auth.php');
        $authFilePath = config_path('auth.php');
        $authContents = $filesystem->get($authFilePath);

        if (!str_contains($authContents, "'api' =>")) {
            $newConfig = "\n        'api' => [\n";
            $newConfig .= "             'driver' => 'passport',\n";
            $newConfig .= "             'provider' => 'users',\n";
            $newConfig .= "             'expire_in' => 60,\n";
            $newConfig .= "         ],\n";
        
            $authContents = str_replace("'guards' => [", "'guards' => [\n" . $newConfig, $authContents);
        
            $filesystem->put($authFilePath, $authContents);
        }

        $this->info('Guard added successfully!');

        

        $this->info('Laravo has been installed.');
    }
}
