<?php

namespace Gnepiew\Permission;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/permission.php', 'permission');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../stubs/database/migrations/add_title_and_description_permissions_and_roles.php.stub' => $this->getMigrationFileName('add_title_and_description_permissions_and_roles.php'),
        ], 'permission-migrations');

        $this->publishes([
            __DIR__.'/../config/permission.php' => config_path('permission.php'),
        ], 'permission-config');

        $this->commands([
            Console\InstallCommand::class,
            Console\PermissionCreateCommand::class,
            Console\RoleCreateCommand::class,
        ]);
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @return string
     */
    protected function getMigrationFileName($migrationFileName): string
    {
        $timestamp = date('Y_m_d_His', strtotime("+1 second"));

        $filesystem = $this->app->make(Filesystem::class);

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
