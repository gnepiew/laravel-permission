<?php

namespace Gnepiew\Permission\Models;

use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    /**
     * Find or create permission by its name (and optionally guardName, title, description).
     *
     * @param string $name
     * @param string|null $guardName
     * @param string|null $title
     * @param string|null $description
     * @return PermissionContract
     */
    public static function findOrCreate(string $name, $guardName = null, $title = null, $description = null): PermissionContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);
        $permission = static::getPermissions(['name' => $name, 'guard_name' => $guardName])->first();

        if (! $permission) {
            return static::query()->create([
                'name' => $name,
                'guard_name' => $guardName,
                'title' => $title ?? $name,
                'description' => $description,
            ]);
        }

        return $permission;
    }
}
