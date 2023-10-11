<?php

namespace Triptasoft\Laravo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use TCG\Voyager\Models\Permission;

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
        $this->info('Migrating & Seeding database');
        Artisan::call('voyager:install --with-dummy');
        Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);
        Artisan::call('migrate', ['--path' => 'vendor/triptasoft/laravo/database/migrations']);

        $this->info('Installing passport');
        Artisan::call('passport:install');

        $this->info('Publishing assets');
        Artisan::call('vendor:publish', ['--provider' => 'Joy\VoyagerApi\VoyagerApiServiceProvider', '--force' => true]);
        Artisan::call('vendor:publish', ['--provider' => 'MonstreX\VoyagerExtension\VoyagerExtensionServiceProvider', '--tag' => 'config']);
        Artisan::call('vendor:publish --tag=laravo --force');
        Artisan::call('db:seed', ['--class' => 'LaravoSettingsTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'ChartsTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'LaravoDataTypesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'LaravoDataRowsTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'LaravoMenuItemsTableSeeder']);
        Permission::generateFor('charts');

        Artisan::call('route:cache');
        Artisan::call('cache:clear');

        Artisan::call('joy-voyager-api:l5-swagger:generate');

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

        $this->info('Adding swagger to config/l5-swagger.php');
        $l5FilePath = config_path('l5-swagger.php');
        $l5Contents = $filesystem->get($l5FilePath);

        if (str_contains($l5Contents, "L5_SWAGGER_BASE_PATH")) {
            $newConfig = "APP_URL";
        
            $l5Contents = str_replace("L5_SWAGGER_BASE_PATH", $newConfig, $l5Contents);
        
            $filesystem->put($l5FilePath, $l5Contents);
        }

        $this->info('Swagger added successfully!');

        $this->info('Adding fillable to Models/User.php');
        $userFilePath = app_path('Models/User.php'); // Adjust the path to your User model
        $userContents = $filesystem->get($userFilePath);

        if (str_contains($userContents, "'provider_id',")) {
            // 'provider_id' is already in the fillable array; no need to add it.
            // You can add an else block here if you want to add it if it's not present.
        } else {
            // Add 'provider_id' to the $fillable array
            $userContents = str_replace(
                "'password',",
                "'password',\n        'provider_id',", // Add 'provider_id' after 'password'
                $userContents
            );
        
            $filesystem->put($userFilePath, $userContents);
        }

        $this->info('Fillable added successfully!');

        

        $this->info('Laravo has been installed.');
    }
}
