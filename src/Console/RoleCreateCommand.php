<?php

namespace Gnepiew\Permission\Console;

use Spatie\Permission\Commands\CreateRole;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Contracts\Role as RoleContract;

class RoleCreateCommand extends CreateRole
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:role-create
        {name : The name of the role}
        {--g|guard= : The name of the guard}
        {--p|permissions= : A list of permissions to assign to the role, separated by | }
        {--t|title= : The title of the role}
        {--d|description= : The description of the role}';

    protected $description = 'Create a role (title and description are optional)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $roleClass = app(RoleContract::class);

        $role = $roleClass::findOrCreate(
            $this->argument('name'),
            $this->option('guard'),
            $this->option('title'),
            $this->option('description')
        );

        $role->givePermissionTo($this->makePermissions($this->option('permissions')));

        $this->info("Role `{$role->name}` created");

        return 0;
    }

    /**
     * @param array|null|string $string
     */
    protected function makePermissions($string = null)
    {
        if (empty($string)) {
            return;
        }

        $permissionClass = app(PermissionContract::class);

        $permissions = explode('|', $string);

        $models = [];

        foreach ($permissions as $permission) {
            $models[] = $permissionClass::findOrCreate(trim($permission), $this->option('guard'));
        }

        return collect($models);
    }
}
