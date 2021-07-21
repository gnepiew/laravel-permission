<?php

namespace Gnepiew\Permission\Console;

use Spatie\Permission\Commands\CreatePermission;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class PermissionCreateCommand extends CreatePermission
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create
                {name : The name of the permission}
                {--g|guard= : The name of the guard}
                {--t|title= : The title of the permission}
                {--d|description= : The description of the permission}';

    protected $description = 'Create a permission (title and description are optional)';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $permissionClass = app(PermissionContract::class);

        $permission = $permissionClass::findOrCreate(
            $this->argument('name'),
            $this->option('guard'),
            $this->option('title'),
            $this->option('description')
        );

        $this->info("Permission `{$permission->name}` created");
    }
}
