<?php

namespace Triptasoft\Laravo\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TCG\Voyager\Database\DatabaseUpdater;
use TCG\Voyager\Database\Schema\Column;
use TCG\Voyager\Database\Schema\Identifier;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\TableAdded;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaravoDatabaseController extends \TCG\Voyager\Http\Controllers\VoyagerDatabaseController
{

    /**
     * Store new database table.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('browse_database');

        try {
            $conn = 'database.connections.'.config('database.default');
            Type::registerCustomPlatformTypes();

            $table = $request->table;
            if (!is_array($request->table)) {
                $table = json_decode($request->table, true);
            }
            $table['options']['collate'] = config($conn.'.collation', 'utf8mb4_unicode_ci');
            $table['options']['charset'] = config($conn.'.charset', 'utf8mb4');
            $table = Table::make($table);
            SchemaManager::createTable($table);

            if (isset($request->create_model) && $request->create_model == 'on') {
                $modelNamespace = config('voyager.models.namespace', app()->getNamespace());
                $params = [
                    'name' => $modelNamespace.Str::studly(Str::singular($table->name)),
                ];

                // if (in_array('deleted_at', $request->input('field.*'))) {
                //     $params['--softdelete'] = true;
                // }

                if (isset($request->create_migration) && $request->create_migration == 'on') {
                    $params['--migration'] = true;
                }
                
                if (isset($request->scope_owner) && $request->scope_owner == 'on') {
                    // Add column to the table
                    Schema::table($table->getName(), function (Blueprint $table) {
                        $table->integer('user_id');
                    });
                    Artisan::call('laravo:make:model', $params);
                }else{
                    Artisan::call('voyager:make:model', $params);
                }
            } elseif (isset($request->create_migration) && $request->create_migration == 'on') {
                Artisan::call('make:migration', [
                    'name'    => 'create_'.$table->name.'_table',
                    '--table' => $table->name,
                ]);
            }

            event(new TableAdded($table));

            return redirect()
               ->route('voyager.database.index')
               ->with($this->alertSuccess(__('voyager::database.success_create_table', ['table' => $table->name])));
        } catch (Exception $e) {
            return back()->with($this->alertException($e))->withInput();
        }
    }
}
