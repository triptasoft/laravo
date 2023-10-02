<?php

namespace Triptasoft\Laravo\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use TCG\Voyager\Events;
use Illuminate\Support\Facades\Artisan;

class LaravoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function handleBreadChanged($event)
    {
        Log::channel('single')->info('BREAD Changed', [
            'Type' => $event->changeType, 
            'Data Type' => $event->dataType->name, 
            'User' => Auth::user()->email
        ]);
        Artisan::call('route:cache');
    }
    public function handleBreadDataChanged($event)
    {
        Log::channel('single')->info('BREAD Data Changed', [
            'Type' => $event->changeType,
            'Data' => $event->data,
            'Data Type' => $event->dataType->name,
            'User' => Auth::user()->email,
        ]);
        
    }
    public function handleTableChanged($event)
    {
        Log::channel('single')->info('Table Changed', [
            'Name' => $event->name, 
            'User' => Auth::user()->email
        ]);
    }

    public function handleTableDeleted($event)
    {
        $modelFileName = Str::studly(Str::singular($event->name)) . '.php';
        $modelFilePath = app_path($modelFileName);

        if (File::exists($modelFilePath)) {
            File::delete($modelFilePath);
            Log::channel('single')->info('Model Deleted => ',['Name' => "{$modelFileName}", 'User' => Auth::user()->email]);
        }
    }

    public function handleAuth(Login $event)
    {
        Log::channel('single')->info('Logged In', [
            'User' => $event->user
        ]);
    }
    
    public function subscribe($events)
    {
        $events->listen(
            Events\BreadDataChanged::class,
            [LaravoListener::class, 'handleBreadDataChanged']
        );

        $events->listen(
            Events\BreadChanged::class,
            [LaravoListener::class, 'handleBreadChanged']
        );

        $events->listen(
            Events\TableChanged::class,
            [LaravoListener::class, 'handleTableChanged']
        );

        $events->listen(
            Events\TableDeleted::class,
            [LaravoListener::class, 'handleTableDeleted']
        );

        $events->listen(
            Login::class,
            [LaravoListener::class, 'handleAuth']
        );

    }
}
